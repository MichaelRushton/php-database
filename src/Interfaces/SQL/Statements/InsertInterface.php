<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements;

use MichaelRushton\Database\Interfaces\SQL\StatementInterface;
use Stringable;

interface InsertInterface extends StatementInterface
{
    public function into(string|Stringable $table): static;

    public function columns(
        string|array $column,
        string|array ...$columns
    ): static;

    public function values(array $values): static;

    public function select(string|Stringable|callable $stmt): static;
}
