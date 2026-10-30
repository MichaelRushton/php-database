<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\MySQL;

use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use Stringable;

interface MySQLInsertInterface extends InsertInterface
{
    public function lowPriority(): static;

    public function highPriority(): static;

    public function ignore(): static;

    public function set(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static;

    public function as(
        string $row_alias,
        string|array|null $column_aliases = null
    ): static;

    public function onDuplicateKeyUpdate(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static;
}
