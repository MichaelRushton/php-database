<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

use Generator;
use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use PDO;
use PDOStatement;

interface ConnectionInterface
{
    public function driver(): DriverInterface;

    public function pdo(): ?PDO;

    public function connect(): static;

    public function exec(string $statement): int|false;

    public function query(
        string $query,
        ?int $fetchMode = null,
        mixed ...$fetchModeArgs
    ): PDOStatement|false;

    public function prepare(
        string $query,
        array $options = []
    ): PDOStatement|false;

    public function bindValues(
        string $query,
        array|string|int|float|bool|null $params = null
    ): PDOStatement|false;

    public function execute(
        string $query,
        array|string|int|float|bool|null $params = null
    ): PDOStatement|false;

    public function fetch(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed;

    public function fetchAll(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $mode = PDO::FETCH_DEFAULT,
        mixed ...$args
    ): array|false;

    public function fetchColumn(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $column = 0
    ): mixed;

    public function fetchObject(
        string $query,
        array|string|int|float|bool|null $params = null,
        ?string $class = 'stdClass',
        array $constructorArgs = []
    ): object|false;

    public function yield(
        string $query,
        array|string|int|float|bool|null $params = null,
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): Generator;

    public function transaction(callable $callback): bool;

    public function close(): static;

    public function delete(): DeleteInterface;

    public function insert(): InsertInterface;

    public function select(): SelectInterface;

    public function update(): UpdateInterface;

    public function listen(
        string $event,
        callable $callback
    ): static;

    public function dispatch(object $event): void;

    public function beforeExec(callable $callback): static;

    public function afterExec(callable $callback): static;

    public function beforeQuery(callable $callback): static;

    public function afterQuery(callable $callback): static;

    public function beforePrepare(callable $callback): static;

    public function afterPrepare(callable $callback): static;

    public function beforeBindValue(callable $callback): static;

    public function afterBindValue(callable $callback): static;

    public function beforeExecute(callable $callback): static;

    public function afterExecute(callable $callback): static;

    public function beforeFetch(callable $callback): static;

    public function afterFetch(callable $callback): static;

    public function beforeFetchAll(callable $callback): static;

    public function afterFetchAll(callable $callback): static;

    public function beforeFetchColumn(callable $callback): static;

    public function afterFetchColumn(callable $callback): static;

    public function beforeFetchObject(callable $callback): static;

    public function afterFetchObject(callable $callback): static;

    public function beforeConnect(callable $callback): static;

    public function afterConnect(callable $callback): static;

    public function beforeBeginTransaction(callable $callback): static;

    public function afterBeginTransaction(callable $callback): static;

    public function beforeCommit(callable $callback): static;

    public function afterCommit(callable $callback): static;

    public function beforeRollBack(callable $callback): static;

    public function afterRollBack(callable $callback): static;

    public function beforeClose(callable $callback): static;

    public function afterClose(callable $callback): static;

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;
}
