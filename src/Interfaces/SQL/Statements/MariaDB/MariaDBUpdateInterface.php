<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB;

use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use Stringable;

interface MariaDBUpdateInterface extends UpdateInterface
{
    public function lowPriority(): static;

    public function ignore(): static;

    public function straightJoin(
        string|Stringable|array $table,
        string|Stringable|int|float|bool|array|callable|null $column1 = null,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $column2 = null
    ): static;

    public function naturalJoin(string|Stringable|array $table): static;

    public function naturalLeftJoin(string|Stringable|array $table): static;

    public function naturalRightJoin(string|Stringable|array $table): static;

    public function naturalFullJoin(string|Stringable|array $table): static;

    public function orderBy(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDesc(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function limit(
        int|string|Stringable $row_count,
        int|string|Stringable|null $offset = null
    ): static;

    public function returning(
        string|Stringable|int|float|bool|array|null $column = '*',
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;
}
