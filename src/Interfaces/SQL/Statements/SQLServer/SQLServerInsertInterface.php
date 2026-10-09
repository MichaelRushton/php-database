<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer;

use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use Stringable;

interface SQLServerInsertInterface extends InsertInterface
{
    public function with(
        string $name,
        string|Stringable|callable $stmt,
        ?callable $callback = null,
    ): static;

    public function recursive(): static;

    public function top(int|float|string|Stringable $row_count): static;

    public function percent(): static;

    public function withTies(): static;

    public function output(
        string|Stringable|int|float|bool|array|null $column,
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;
}
