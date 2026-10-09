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
use MichaelRushton\Database\Events\AfterBindValueEvent;
use MichaelRushton\Database\Events\AfterExecEvent;
use MichaelRushton\Database\Events\AfterExecuteEvent;
use MichaelRushton\Database\Events\AfterFetchAllEvent;
use MichaelRushton\Database\Events\AfterFetchColumnEvent;
use MichaelRushton\Database\Events\AfterFetchObjectEvent;
use MichaelRushton\Database\Events\AfterPrepareEvent;
use MichaelRushton\Database\Events\AfterQueryEvent;
use MichaelRushton\Database\Events\BeforeBindValueEvent;
use MichaelRushton\Database\Events\BeforeExecEvent;
use MichaelRushton\Database\Events\BeforeExecuteEvent;
use MichaelRushton\Database\Events\BeforeFetchAllEvent;
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;
use MichaelRushton\Database\Events\BeforePrepareEvent;
use MichaelRushton\Database\Events\BeforeQueryEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
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

    public function __construct(
        public readonly ConnectionInterface $connection
    ) {}

    public function connection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function exec(): int|false
    {

        $this->connection->connect();

        $before_event = new BeforeExecEvent($this->connection, (string) $this);

        $this->dispatch($before_event);

        $count = $this->connection->exec($this->to_string);

        $this->dispatch(new AfterExecEvent($before_event, $count));

        return $count;

    }

    public function query(
        ?int $fetchMode = null,
        mixed ...$fetchModeArgs
    ): PDOStatement|false {

        $this->connection->connect();

        $before_event = new BeforeQueryEvent($this->connection, (string) $this, $fetchMode, $fetchModeArgs);

        $this->dispatch($before_event);

        $stmt = $this->connection->query($this->to_string, $fetchMode, ...$fetchModeArgs);

        $this->dispatch(new AfterQueryEvent($before_event, $stmt));

        return $stmt;

    }

    public function prepare(array $options = []): PDOStatement|false
    {

        $this->connection->connect();

        $before_event = new BeforePrepareEvent($this->connection, (string) $this, $options);

        $this->dispatch($before_event);

        $stmt = $this->connection->prepare($this->to_string, $options);

        $this->dispatch(new AfterPrepareEvent($before_event, $stmt));

        return $stmt;

    }

    public function bindValues(): PDOStatement|false
    {

        if (!$stmt = $this->prepare()) {
            return false;
        }

        $bind_value = new BindValue();

        foreach ($this->bindings() as $param => $value) {

            $before_event = new BeforeBindValueEvent($this->connection, $stmt, $this->to_string, $param, $value);

            $this->dispatch($before_event);

            $success = $bind_value->handle($this->connection, $stmt, $this->to_string, $param, $value);

            $this->dispatch(new AfterBindValueEvent($before_event, $success));

        }

        return $stmt;

    }

    public function execute(): PDOStatement|false
    {

        if (!$stmt = $this->bindValues()) {
            return false;
        }

        $before_event = new BeforeExecuteEvent($this->connection, $stmt, $this->to_string, $this->bindings());

        $this->dispatch($before_event);

        $stmt = new Execute()->handle($this->connection, $stmt, $this->to_string, $before_event->params);

        $this->dispatch(new AfterExecuteEvent($before_event, (bool) $stmt));

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

        return new Fetch()->handle($this, $stmt, $this->to_string, $this->bindings(), $mode, $cursorOrientation, $cursorOffset);

    }

    public function fetchAll(
        int $mode = PDO::FETCH_DEFAULT,
        mixed ...$args
    ): array|false {

        if (!$stmt = $this->execute()) {
            return false;
        }

        $before_event = new BeforeFetchAllEvent($this->connection, $stmt, $this->to_string, $this->bindings(), $mode, $args);

        $this->dispatch($before_event);

        $rows = new FetchAll()->handle($this->connection, $stmt, $this->to_string, $before_event->params, $mode, ...$args);

        $this->dispatch(new AfterFetchAllEvent($before_event, $rows));

        return $rows;

    }

    public function fetchColumn(int $column = 0): mixed
    {

        if (!$stmt = $this->execute()) {
            return false;
        }

        $before_event = new BeforeFetchColumnEvent($this->connection, $stmt, $this->to_string, $this->bindings(), $column);

        $this->dispatch($before_event);

        $value = new FetchColumn()->handle($this->connection, $stmt, $this->to_string, $before_event->params, $column);

        $this->dispatch(new AfterFetchColumnEvent($before_event, $value));

        return $value;

    }

    public function fetchObject(
        ?string $class = 'stdClass',
        array $constructorArgs = []
    ): object|false {

        if (!$stmt = $this->execute()) {
            return false;
        }

        $before_event = new BeforeFetchObjectEvent($this->connection, $stmt, $this->to_string, $this->bindings(), $class, $constructorArgs);

        $this->dispatch($before_event);

        $object = new FetchObject()->handle($this->connection, $stmt, $this->to_string, $before_event->params, $class, $constructorArgs);

        $this->dispatch(new AfterFetchObjectEvent($before_event, $object));

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

        $fetch = new Fetch();

        $bindings = $this->bindings();

        while (false !== $row = $fetch->handle($this, $stmt, $this->to_string, $bindings, $mode, $cursorOrientation, $cursorOffset)) {
            yield $row;
        }

    }

    public function __toString(): string
    {

        $this->bindings = [];

        return $this->to_string = implode(' ', array_filter($this->toArray(), '\strlen'));

    }
}
