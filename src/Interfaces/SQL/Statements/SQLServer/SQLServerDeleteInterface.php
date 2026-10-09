<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer;

use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use Stringable;

interface SQLServerDeleteInterface extends DeleteInterface
{
    public function top(int|float|string|Stringable $row_count): static;

    public function percent(): static;

    public function table(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static;

    public function output(
        string|Stringable|int|float|bool|array|null $column,
        string|Stringable|int|float|bool|array|null ...$columns
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

    public function whereCurrentOf(string $cursor): static;
}
