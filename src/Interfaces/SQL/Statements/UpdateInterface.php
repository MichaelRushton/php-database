<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements;

use MichaelRushton\Database\Interfaces\SQL\StatementInterface;
use Stringable;

interface UpdateInterface extends StatementInterface
{
    public function with(
        string $name,
        string|Stringable|callable $stmt,
        ?callable $callback = null,
    ): static;

    public function recursive(): static;

    public function table(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static;

    public function set(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
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
}
