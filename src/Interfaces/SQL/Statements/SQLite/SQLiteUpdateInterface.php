<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\SQLite;

use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use Stringable;

interface SQLiteUpdateInterface extends UpdateInterface
{
    public function orFail(): static;

    public function orIgnore(): static;

    public function orReplace(): static;

    public function orRollBack(): static;

    public function from(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static;

    public function naturalJoin(string|Stringable|array $table): static;

    public function naturalLeftJoin(string|Stringable|array $table): static;

    public function naturalRightJoin(string|Stringable|array $table): static;

    public function naturalFullJoin(string|Stringable|array $table): static;

    public function returning(
        string|Stringable|int|float|bool|array|null $column = '*',
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;

    public function orderBy(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDesc(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByNullsFirst(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByNullsLast(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDescNullsFirst(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDescNullsLast(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function limit(
        int|string|Stringable $row_count,
        int|string|Stringable|null $offset = null
    ): static;
}
