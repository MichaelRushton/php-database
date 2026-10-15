<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\SQLite;

use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use Stringable;

interface SQLiteInsertInterface extends InsertInterface
{
    public function with(
        string $name,
        string|Stringable|callable $stmt,
        ?callable $callback = null,
    ): static;

    public function recursive(): static;

    public function orFail(): static;

    public function orIgnore(): static;

    public function orReplace(): static;

    public function orRollBack(): static;

    public function onConflictDoNothing(?callable $callback = null): static;

    public function onConflictDoUpdateSet(
        string|array $column,
        string|Stringable|int|float|bool|callable|null $value = null,
        ?callable $callback = null
    ): static;

    public function returning(
        string|Stringable|int|float|bool|array|null $column = '*',
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;
}
