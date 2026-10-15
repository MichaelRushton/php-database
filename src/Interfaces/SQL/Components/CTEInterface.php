<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Components;

interface CTEInterface
{
    public function columns(
        string|array $column,
        string|array ...$columns
    ): static;

    public function materialized(): static;

    public function notMaterialized(): static;

    public function cycleRestrict(
        string|array $column,
        string|array ...$columns
    ): static;

    public function searchBreadth(
        string|array $first_by,
        string $set
    ): static;

    public function searchDepth(
        string|array $first_by,
        string $set
    ): static;

    public function cycle(
        string|array $columns,
        string $set = 'is_cycle',
        string $using = 'path'
    ): static;

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;
}
