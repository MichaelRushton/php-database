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
use MichaelRushton\Database\Interfaces\ConfigurationInterface;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\EventManagerInterface;
use MichaelRushton\Database\Traits\Events;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use MichaelRushton\Exceptions\TransactionNotStartedException;
use PDO;
use PDOStatement;
use Throwable;

abstract class Connection implements ConnectionInterface
{
    use Events;
    use Pipe;
    use Through;
    use When;

    public protected(set) ?PDO $pdo = null;
    public protected(set) int $transaction = 0;

    protected BindValue $bind_value;
    protected Execute $execute;
    protected Fetch $fetch;
    protected FetchAll $fetch_all;
    protected FetchColumn $fetch_column;
    protected FetchObject $fetch_object;

    public function __construct(
        public protected(set) DriverInterface $driver,
        public protected(set) ConfigurationInterface $configuration = new Configuration(),
        public protected(set) CacheInterface $cache = new Cache(),
        public protected(set) EventManagerInterface $event_manager = new EventManager()
    ) {

        $this->bind_value = new BindValue();
        $this->execute = new Execute();
        $this->fetch = new Fetch();
        $this->fetch_all = new FetchAll();
        $this->fetch_column = new FetchColumn();
        $this->fetch_object = new FetchObject();

    }

    public function connect(): static
    {

        if (!$this->pdo) {

            $this->event_manager->dispatch($before_event = new BeforeConnectEvent($this));

            $this->pdo = PDO::connect($this->driver->dsn, $this->driver->username, $this->driver->password, $this->driver->pdo_options);

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

        if (!$this->configuration->cache_prepared_statements) {
            return $this->uncached($query, $options);
        }

        $key = $this->cache->key($query . json_encode($options));

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
        mixed $params = null
    ): PDOStatement|false {

        if (!$stmt = $this->prepare($query)) {
            return false;
        }

        foreach ((array) $params as $param => $value) {
            $this->bind_value->handle($this, $stmt, $query, $param, $value);
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

        return $this->execute->handle($this, $stmt, $query, $params);

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

        return $this->fetch->handle($this, $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset);

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

        return $this->fetch_all->handle($this, $stmt, $query, $params, $mode, ...$args);

    }

    public function fetchColumn(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $column = 0
    ): mixed {

        if (!$stmt = $this->execute($query, $params)) {
            return false;
        }

        return $this->fetch_column->handle($this, $stmt, $query, $params, $column);

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

        return $this->fetch_object->handle($this, $stmt, $query, $params, $class, $constructorArgs);

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

        while (false !== $row = $this->fetch->handle($this, $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset)) {
            yield $row;
        }

    }

    public function beginTransaction(): bool
    {

        if ($this->transaction++) {
            return false !== $this->pdo->exec("{$this->driver->savepoint} transaction$this->transaction");
        }

        $this->connect();

        $this->event_manager->dispatch($before_event = new BeforeBeginTransactionEvent($this));

        $success = $this->pdo->beginTransaction();

        $this->event_manager->dispatch(new AfterBeginTransactionEvent($before_event, $success));

        return $success;

    }

    public function commit(): bool
    {

        if (!$this->transaction) {
            throw new TransactionNotStartedException();
        }

        if (--$this->transaction) {
            return true;
        }

        $this->event_manager->dispatch($before_event = new BeforeCommitEvent($this));

        $success = $this->pdo->commit();

        $this->event_manager->dispatch(new AfterCommitEvent($before_event, $success));

        return $success;

    }

    public function rollBack(?Throwable $exception = null): bool
    {

        if (!$this->transaction) {
            throw new TransactionNotStartedException();
        }

        if (--$this->transaction) {
            return false !== $this->pdo->exec("{$this->driver->roll_back_to} transaction" . $this->transaction + 1);
        }

        $this->event_manager->dispatch($before_event = new BeforeRollBackEvent($this, $exception));

        $success = $this->pdo->rollBack();

        $this->event_manager->dispatch(new AfterRollBackEvent($before_event, $success));

        return $success;

    }

    public function transaction(callable $callback): bool
    {

        // @codeCoverageIgnoreStart
        if (!$this->beginTransaction()) {
            return false;
        }
        // @codeCoverageIgnoreEnd

        try {

            $callback($this);

            return $this->commit();

        } catch (Throwable $e) {

            $this->rollBack($e);

            throw $e;

        }

    }

    public function close(): static
    {

        if ($this->pdo) {

            $this->event_manager->dispatch($before_event = new BeforeCloseEvent($this));

            $this->pdo = null;

            $this->transaction = 0;

            $this->cache->clear();

            $this->event_manager->dispatch(new AfterCloseEvent($before_event));

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
