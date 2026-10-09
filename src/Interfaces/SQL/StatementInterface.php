<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL;

use Generator;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDO;
use PDOStatement;

interface StatementInterface
{
    public function connection(): ConnectionInterface;

    public function exec(): int|false;

    public function query(
        ?int $fetchMode = null,
        mixed ...$fetchModeArgs
    ): PDOStatement|false;

    public function prepare(array $options = []): PDOStatement|false;

    public function execute(): PDOStatement|false;

    public function fetch(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed;

    public function fetchAll(
        int $mode = PDO::FETCH_DEFAULT,
        mixed ...$args
    ): array|false;

    public function fetchColumn(int $column = 0): mixed;

    public function fetchObject(
        ?string $class = 'stdClass',
        array $constructorArgs = []
    ): object|false;

    public function yield(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): Generator;

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

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;

    public function toArray(): array;
}
