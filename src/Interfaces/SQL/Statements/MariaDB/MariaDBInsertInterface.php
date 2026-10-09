<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB;

use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use Stringable;

interface MariaDBInsertInterface extends InsertInterface
{
    public function lowPriority(): static;

    public function delayed(): static;

    public function highPriority(): static;

    public function ignore(): static;

    public function set(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static;

    public function onDuplicateKeyUpdate(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static;

    public function returning(
        string|Stringable|int|float|bool|array|null $column = '*',
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;
}
