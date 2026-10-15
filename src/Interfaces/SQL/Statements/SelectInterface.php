<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements;

use MichaelRushton\Database\Interfaces\SQL\Components\SubqueryInterface;
use MichaelRushton\Database\Interfaces\SQL\StatementInterface;
use Stringable;

interface SelectInterface extends StatementInterface
{
    public function with(
        string $name,
        string|Stringable|callable $stmt,
        ?callable $callback = null,
    ): static;

    public function recursive(): static;

    public function distinct(): static;

    public function columns(
        string|Stringable|int|float|bool|array|null $column,
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;

    public function from(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static;

    public function join(
        string|Stringable|array $table,
        string|Stringable|int|float|bool|array|callable|null $column1 = null,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $column2 = null
    ): static;

    public function leftJoin(
        string|Stringable|array $table,
        string|Stringable|int|float|bool|array|callable|null $column1 = null,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $column2 = null
    ): static;

    public function rightJoin(
        string|Stringable|array $table,
        string|Stringable|int|float|bool|array|callable|null $column1 = null,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $column2 = null
    ): static;

    public function fullJoin(
        string|Stringable|array $table,
        string|Stringable|int|float|bool|array|callable|null $column1 = null,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $column2 = null
    ): static;

    public function crossJoin(string|Stringable|array $table): static;

    public function where(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function orWhere(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function whereNot(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function orWhereNot(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function whereIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function orWhereIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function whereNotIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function orWhereNotIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function whereBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function orWhereBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function whereNotBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function orWhereNotBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function whereNull(string|Stringable $column): static;

    public function orWhereNull(string|Stringable $column): static;

    public function whereNotNull(string|Stringable $column): static;

    public function orWhereNotNull(string|Stringable $column): static;

    public function groupBy(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function having(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function orHaving(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function havingNot(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function orHavingNot(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function havingIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function orHavingIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function havingNotIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function orHavingNotIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static;

    public function havingBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function orHavingBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function havingNotBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function orHavingNotBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static;

    public function havingNull(string|Stringable $column): static;

    public function orHavingNull(string|Stringable $column): static;

    public function havingNotNull(string|Stringable $column): static;

    public function orHavingNotNull(string|Stringable $column): static;

    public function union(string|Stringable|callable|array $stmt): static;

    public function unionAll(string|Stringable|callable|array $stmt): static;

    public function intersect(string|Stringable|callable|array $stmt): static;

    public function except(string|Stringable|callable|array $stmt): static;

    public function orderBy(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDesc(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function toSubquery(): SubqueryInterface;
}
