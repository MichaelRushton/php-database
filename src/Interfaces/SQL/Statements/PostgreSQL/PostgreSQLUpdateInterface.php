<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL;

use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use Stringable;

interface PostgreSQLUpdateInterface extends UpdateInterface
{
    public function from(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static;

    public function naturalJoin(string|Stringable|array $table): static;

    public function naturalLeftJoin(string|Stringable|array $table): static;

    public function naturalRightJoin(string|Stringable|array $table): static;

    public function naturalFullJoin(string|Stringable|array $table): static;

    public function whereCurrentOf(string $cursor): static;

    public function returning(
        string|Stringable|int|float|bool|array|null $column = '*',
        string|Stringable|int|float|bool|array|null ...$columns
    ): static;
}
