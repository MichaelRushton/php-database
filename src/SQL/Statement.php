<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL;

use Generator;
use MichaelRushton\Database\Actions\Connection\BindValue;
use MichaelRushton\Database\Actions\Connection\Execute;
use MichaelRushton\Database\Actions\Connection\FetchAll;
use MichaelRushton\Database\Actions\Connection\FetchColumn;
use MichaelRushton\Database\Actions\Connection\FetchObject;
use MichaelRushton\Database\Actions\SQL\Statement\Fetch;
use MichaelRushton\Database\Actions\SQL\Statement\Prepare;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Events\AfterBindValueEvent;
use MichaelRushton\Database\Events\AfterExecEvent;
use MichaelRushton\Database\Events\AfterExecuteEvent;
use MichaelRushton\Database\Events\AfterFetchAllEvent;
use MichaelRushton\Database\Events\AfterFetchColumnEvent;
use MichaelRushton\Database\Events\AfterFetchObjectEvent;
use MichaelRushton\Database\Events\AfterQueryEvent;
use MichaelRushton\Database\Events\BeforeBindValueEvent;
use MichaelRushton\Database\Events\BeforeExecEvent;
use MichaelRushton\Database\Events\BeforeExecuteEvent;
use MichaelRushton\Database\Events\BeforeFetchAllEvent;
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;
use MichaelRushton\Database\Events\BeforeQueryEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\EventManagerInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Interfaces\SQL\StatementInterface;
use MichaelRushton\Database\Traits\Events;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use PDO;
use PDOStatement;
use Stringable;

abstract class Statement implements StatementInterface, HasBindings, Stringable
{
    use Bindings;
    use Events;
    use Pipe;
    use Through;
    use When;

    protected string $to_string = '';
    protected Prepare $prepare;
    protected BindValue $bind_value;
    protected Execute $execute;
    protected Fetch $fetch;
    protected FetchAll $fetch_all;
    protected FetchColumn $fetch_column;
    protected FetchObject $fetch_object;

    public function __construct(
        public protected(set) ConnectionInterface $connection,
        public protected(set) EventManagerInterface $event_manager = new EventManager()
    ) {

        $this->prepare = new Prepare();
        $this->bind_value = new BindValue();
        $this->execute = new Execute();
        $this->fetch = new Fetch();
        $this->fetch_all = new FetchAll();
        $this->fetch_column = new FetchColumn();
        $this->fetch_object = new FetchObject();

    }

    public function exec(): int|false
    {

        $this->connection->connect();

        $before_event = new BeforeExecEvent($this->connection, (string) $this);

        $this->event_manager->dispatch($before_event);

        $count = $this->connection->exec($this->to_string);

        $this->event_manager->dispatch(new AfterExecEvent($before_event, $count));

        return $count;

    }

    public function query(
        ?int $fetchMode = null,
        mixed ...$fetchModeArgs
    ): PDOStatement|false {

        $this->connection->connect();

        $before_event = new BeforeQueryEvent($this->connection, (string) $this, $fetchMode, $fetchModeArgs);

        $this->event_manager->dispatch($before_event);

        $stmt = $this->connection->query($this->to_string, $fetchMode, ...$fetchModeArgs);

        $this->event_manager->dispatch(new AfterQueryEvent($before_event, $stmt));

        return $stmt;

    }

    public function prepare(array $options = []): PDOStatement|false
    {

        if (!$this->connection->configuration->cache_prepared_statements) {
            return $this->uncached($options);
        }

        $key = $this->connection->cache->key($this . json_encode($options));

        if ($stmt = $this->connection->cache->get($key)) {
            return $stmt;
        }

        if ($stmt = $this->prepare->handle($this, $this->to_string, $options)) {
            $this->connection->cache->set($key, $stmt);
        }

        return $stmt;

    }

    public function uncached(array $options = []): PDOStatement|false
    {
        return $this->prepare->handle($this, (string) $this, $options);
    }

    public function bindValues(): PDOStatement|false
    {

        if (!$stmt = $this->prepare()) {
            return false;
        }

        foreach ($this->bindings as $param => $value) {

            $before_event = new BeforeBindValueEvent($this->connection, $stmt, $this->to_string, $param, $value);

            $this->event_manager->dispatch($before_event);

            $success = $this->bind_value->handle($this->connection, $stmt, $this->to_string, $param, $value);

            $this->event_manager->dispatch(new AfterBindValueEvent($before_event, $success));

        }

        return $stmt;

    }

    public function execute(): PDOStatement|false
    {

        if (!$stmt = $this->bindValues()) {
            return false;
        }

        $before_event = new BeforeExecuteEvent($this->connection, $stmt, $this->to_string, $this->bindings);

        $this->event_manager->dispatch($before_event);

        $stmt = $this->execute->handle($this->connection, $stmt, $this->to_string, $this->bindings);

        $this->event_manager->dispatch(new AfterExecuteEvent($before_event, (bool) $stmt));

        return $stmt;

    }

    public function fetch(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed {

        if (!$stmt = $this->execute()) {
            return false;
        }

        return $this->fetch->handle($this, $stmt, $this->to_string, $this->bindings, $mode, $cursorOrientation, $cursorOffset);

    }

    public function fetchAll(
        int $mode = PDO::FETCH_DEFAULT,
        mixed ...$args
    ): array|false {

        if (!$stmt = $this->execute()) {
            return false;
        }

        $before_event = new BeforeFetchAllEvent($this->connection, $stmt, $this->to_string, $this->bindings, $mode, $args);

        $this->event_manager->dispatch($before_event);

        $rows = $this->fetch_all->handle($this->connection, $stmt, $this->to_string, $this->bindings, $mode, ...$args);

        $this->event_manager->dispatch(new AfterFetchAllEvent($before_event, $rows));

        return $rows;

    }

    public function fetchColumn(int $column = 0): mixed
    {

        if (!$stmt = $this->execute()) {
            return false;
        }

        $before_event = new BeforeFetchColumnEvent($this->connection, $stmt, $this->to_string, $this->bindings, $column);

        $this->event_manager->dispatch($before_event);

        $value = $this->fetch_column->handle($this->connection, $stmt, $this->to_string, $this->bindings, $column);

        $this->event_manager->dispatch(new AfterFetchColumnEvent($before_event, $value));

        return $value;

    }

    public function fetchObject(
        ?string $class = 'stdClass',
        array $constructorArgs = []
    ): object|false {

        if (!$stmt = $this->execute()) {
            return false;
        }

        $before_event = new BeforeFetchObjectEvent($this->connection, $stmt, $this->to_string, $this->bindings, $class, $constructorArgs);

        $this->event_manager->dispatch($before_event);

        $object = $this->fetch_object->handle($this->connection, $stmt, $this->to_string, $this->bindings, $class, $constructorArgs);

        $this->event_manager->dispatch(new AfterFetchObjectEvent($before_event, $object));

        return $object;

    }

    public function yield(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): Generator {

        if (!$stmt = $this->execute()) {
            return false;
        }

        while (false !== $row = $this->fetch->handle($this, $stmt, $this->to_string, $this->bindings, $mode, $cursorOrientation, $cursorOffset)) {
            yield $row;
        }

    }

    public function __toString(): string
    {

        $this->bindings = [];

        return $this->to_string = implode(' ', array_filter($this->toArray(), '\strlen'));

    }
}
