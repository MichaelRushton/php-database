<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer;

use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use Stringable;

interface SQLServerUpdateInterface extends UpdateInterface
{
    public function top(int|float|string|Stringable $row_count): static;

    public function percent(): static;

    public function output(
        string|Stringable|int|float|bool|array|null $column,
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;

    public function from(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static;

    public function where(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static;

    public function whereCurrentOf(string $cursor): static;
}
