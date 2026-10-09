<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer;

use MichaelRushton\Database\Interfaces\SQL\Statements\SelectInterface;
use Stringable;

interface SQLServerSelectInterface extends SelectInterface
{
    public function top(int|float|string|Stringable $row_count): static;

    public function percent(): static;

    public function withTies(): static;

    public function into(string|Stringable $table): static;

    public function window(
        string $name,
        ?callable $callback = null,
    ): static;

    public function offsetFetch(
        int|string|Stringable $offset,
        int|string|Stringable $row_count
    ): static;
}
