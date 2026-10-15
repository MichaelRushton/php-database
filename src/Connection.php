<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use Generator;
use MichaelRushton\Database\Actions\Connection\BindValue;
use MichaelRushton\Database\Actions\Connection\Execute;
use MichaelRushton\Database\Actions\Connection\Fetch;
use MichaelRushton\Database\Actions\Connection\FetchAll;
use MichaelRushton\Database\Actions\Connection\FetchColumn;
use MichaelRushton\Database\Actions\Connection\FetchObject;
use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Events\AfterBeginTransactionEvent;
use MichaelRushton\Database\Events\AfterCloseEvent;
use MichaelRushton\Database\Events\AfterCommitEvent;
use MichaelRushton\Database\Events\AfterConnectEvent;
use MichaelRushton\Database\Events\AfterExecEvent;
use MichaelRushton\Database\Events\AfterPrepareEvent;
use MichaelRushton\Database\Events\AfterQueryEvent;
use MichaelRushton\Database\Events\AfterRollBackEvent;
use MichaelRushton\Database\Events\BeforeBeginTransactionEvent;
use MichaelRushton\Database\Events\BeforeCloseEvent;
use MichaelRushton\Database\Events\BeforeCommitEvent;
use MichaelRushton\Database\Events\BeforeConnectEvent;
use MichaelRushton\Database\Events\BeforeExecEvent;
use MichaelRushton\Database\Events\BeforePrepareEvent;
use MichaelRushton\Database\Events\BeforeQueryEvent;
use MichaelRushton\Database\Events\BeforeRollBackEvent;
use MichaelRushton\Database\Interfaces\CacheInterface;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\EventManagerInterface;
use MichaelRushton\Database\Interfaces\Settings\ConnectionSettingsInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;
use MichaelRushton\Database\Traits\Events;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use PDO;
use PDOStatement;
use Throwable;

abstract class Connection implements ConnectionInterface
{
    use Events;
    use Pipe;
    use Through;
    use When;

    protected ?PDO $pdo = null;

    public function __construct(
        protected DriverInterface $driver,
        protected ConnectionSettingsInterface $settings = new ConnectionSettings(),
        protected CacheInterface $cache = new Cache(),
        protected EventManagerInterface $event_manager = new EventManager()
    ) {}

    public function driver(): DriverInterface
    {
        return $this->driver;
    }

    public function settings(): ConnectionSettingsInterface
    {
        return $this->settings;
    }

    public function cache(): CacheInterface
    {
        return $this->cache;
    }

    public function eventManager(): EventManagerInterface
    {
        return $this->event_manager;
    }

    public function pdo(): ?PDO
    {
        return $this->pdo;
    }

    public function connect(): static
    {

        if (!$this->pdo) {

            $this->event_manager->dispatch($before_event = new BeforeConnectEvent($this));

            $this->pdo = $this->driver->connect();

            $this->event_manager->dispatch(new AfterConnectEvent($before_event));

        }

        return $this;

    }

    public function exec(string $statement): int|false
    {

        $this->connect();

        $this->event_manager->dispatch($before_event = new BeforeExecEvent($this, $statement));

        $count = $this->pdo->exec($statement);

        $this->event_manager->dispatch(new AfterExecEvent($before_event, $count));

        return $count;

    }

    public function query(
        string $query,
        ?int $fetchMode = null,
        mixed ...$fetchModeArgs
    ): PDOStatement|false {

        $this->connect();

        $this->event_manager->dispatch($before_event = new BeforeQueryEvent($this, $query, $fetchMode, $fetchModeArgs));

        $stmt = $this->pdo->query($query, $fetchMode, ...$fetchModeArgs);

        $this->event_manager->dispatch(new AfterQueryEvent($before_event, $stmt));

        return $stmt;

    }

    public function prepare(
        string $query,
        array $options = []
    ): PDOStatement|false {

        if (!$this->settings->getCachePreparedStatements()) {
            return $this->uncached($query, $options);
        }

        $key = $this->cache->key($query);

        if ($stmt = $this->cache->get($key)) {
            return $stmt;
        }

        if ($stmt = $this->uncached($query, $options)) {
            $this->cache->set($key, $stmt);
        }

        return $stmt;

    }

    public function uncached(
        string $query,
        array $options = []
    ): PDOStatement|false {

        $this->connect();

        $this->event_manager->dispatch($before_event = new BeforePrepareEvent($this, $query, $options));

        $stmt = $this->pdo->prepare($query, $options);

        $this->event_manager->dispatch(new AfterPrepareEvent($before_event, $stmt));

        return $stmt;

    }

    public function bindValues(
        string $query,
        array|string|int|float|bool|null $params = null
    ): PDOStatement|false {

        if (!$stmt = $this->prepare($query)) {
            return false;
        }

        $bind_value = new BindValue();

        foreach ((array) $params as $param => $value) {
            $bind_value->handle($this, $stmt, $query, $param, $value);
        }

        return $stmt;

    }

    public function execute(
        string $query,
        array|string|int|float|bool|null $params = null
    ): PDOStatement|false {

        if (!$stmt = $this->bindValues($query, $params)) {
            return false;
        }

        return new Execute()->handle($this, $stmt, $query, $params);

    }

    public function fetch(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed {

        if (!$stmt = $this->execute($query, $params)) {
            return false;
        }

        return new Fetch()->handle($this, $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset);

    }

    public function fetchAll(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $mode = PDO::FETCH_DEFAULT,
        mixed ...$args
    ): array|false {

        if (!$stmt = $this->execute($query, $params)) {
            return false;
        }

        return new FetchAll()->handle($this, $stmt, $query, $params, $mode, ...$args);

    }

    public function fetchColumn(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $column = 0
    ): mixed {

        if (!$stmt = $this->execute($query, $params)) {
            return false;
        }

        return new FetchColumn()->handle($this, $stmt, $query, $params, $column);

    }

    public function fetchObject(
        string $query,
        array|string|int|float|bool|null $params = null,
        ?string $class = 'stdClass',
        array $constructorArgs = []
    ): object|false {

        if (!$stmt = $this->execute($query, $params)) {
            return false;
        }

        return new FetchObject()->handle($this, $stmt, $query, $params, $class, $constructorArgs);

    }

    public function yield(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): Generator {

        if (!$stmt = $this->execute($query, $params)) {
            return false;
        }

        $fetch = new Fetch();

        while (false !== $row = $fetch->handle($this, $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset)) {
            yield $row;
        }

    }

    public function transaction(callable $callback): bool
    {

        $this->connect();

        $this->event_manager->dispatch($before_event = new BeforeBeginTransactionEvent($this));

        $success = $this->pdo->beginTransaction();

        $this->event_manager->dispatch(new AfterBeginTransactionEvent($before_event, $success));

        // @codeCoverageIgnoreStart
        if (!$success) {
            return false;
        }
        // @codeCoverageIgnoreEnd

        try {

            $callback($this);

            $this->event_manager->dispatch($before_event = new BeforeCommitEvent($this));

            $success = $this->pdo->commit();

            $this->event_manager->dispatch(new AfterCommitEvent($before_event, $success));

            return $success;

        } catch (Throwable $e) {

            $this->event_manager->dispatch($before_event = new BeforeRollBackEvent($this, $e));

            $success = $this->pdo->rollBack();

            $this->event_manager->dispatch(new AfterRollBackEvent($before_event, $success));

            throw $e;

        }

    }

    public function close(): static
    {

        if ($this->pdo) {

            $this->event_manager->dispatch($before_event = new BeforeCloseEvent($this));

            $this->pdo = null;

            $this->event_manager->dispatch(new AfterCloseEvent($before_event));

            $this->cache->clear();

        }

        return $this;

    }

    public function beforeConnect(callable $callback): static
    {

        $this->event_manager->listen(BeforeConnectEvent::class, $callback);

        return $this;

    }

    public function afterConnect(callable $callback): static
    {

        $this->event_manager->listen(AfterConnectEvent::class, $callback);

        return $this;

    }

    public function beforeBeginTransaction(callable $callback): static
    {

        $this->event_manager->listen(BeforeBeginTransactionEvent::class, $callback);

        return $this;

    }

    public function afterBeginTransaction(callable $callback): static
    {

        $this->event_manager->listen(AfterBeginTransactionEvent::class, $callback);

        return $this;

    }

    public function beforeCommit(callable $callback): static
    {

        $this->event_manager->listen(BeforeCommitEvent::class, $callback);

        return $this;

    }

    public function afterCommit(callable $callback): static
    {

        $this->event_manager->listen(AfterCommitEvent::class, $callback);

        return $this;

    }

    public function beforeRollBack(callable $callback): static
    {

        $this->event_manager->listen(BeforeRollBackEvent::class, $callback);

        return $this;

    }

    public function afterRollBack(callable $callback): static
    {

        $this->event_manager->listen(AfterRollBackEvent::class, $callback);

        return $this;

    }

    public function beforeClose(callable $callback): static
    {

        $this->event_manager->listen(BeforeCloseEvent::class, $callback);

        return $this;

    }

    public function afterClose(callable $callback): static
    {

        $this->event_manager->listen(AfterCloseEvent::class, $callback);

        return $this;

    }

    public function __destruct()
    {
        $this->close();
    }
}
