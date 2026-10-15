<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Components;

interface SubqueryInterface
{
    public function all(): static;

    public function any(): static;

    public function exists(): static;

    public function in(): static;

    public function lateral(): static;

    public function as(string $alias): static;

    public function columns(
        string|array $column,
        string|array ...$columns
    ): static;

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;
}
