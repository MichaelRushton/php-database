<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Components;

use Stringable;

interface HavingInterface
{
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

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;
}
