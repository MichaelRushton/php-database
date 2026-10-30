<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\MySQL;

use MichaelRushton\Database\Interfaces\SQL\Statements\ReplaceInterface;
use Stringable;

interface MySQLReplaceInterface extends ReplaceInterface
{
    public function lowPriority(): static;

    public function set(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static;
}
