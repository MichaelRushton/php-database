<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL;

use MichaelRushton\Database\Interfaces\SQL\Statements\SelectInterface;
use Stringable;

interface PostgreSQLSelectInterface extends SelectInterface
{
    public function naturalJoin(string|Stringable|array $table): static;

    public function naturalLeftJoin(string|Stringable|array $table): static;

    public function naturalRightJoin(string|Stringable|array $table): static;

    public function naturalFullJoin(string|Stringable|array $table): static;

    public function window(
        string $name,
        ?callable $callback = null,
    ): static;

    public function intersectAll(string|Stringable|callable|array $stmt): static;

    public function exceptAll(string|Stringable|callable|array $stmt): static;

    public function orderByNullsFirst(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByNullsLast(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDescNullsFirst(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function orderByDescNullsLast(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static;

    public function limit(
        int|string|Stringable $row_count,
        int|string|Stringable|null $offset = null
    ): static;

    public function offsetFetch(
        int|string|Stringable $offset,
        int|string|Stringable $row_count
    ): static;

    public function withTies(): static;

    public function forUpdate(string|array|null $table = null): static;

    public function forUpdateNoWait(string|array|null $table = null): static;

    public function forUpdateSkipLocked(string|array|null $table = null): static;

    public function forNoKeyUpdate(string|array|null $table = null): static;

    public function forNoKeyUpdateNoWait(string|array|null $table = null): static;

    public function forNoKeyUpdateSkipLocked(string|array|null $table = null): static;

    public function forShare(string|array|null $table = null): static;

    public function forShareNoWait(string|array|null $table = null): static;

    public function forShareSkipLocked(string|array|null $table = null): static;

    public function forKeyShare(string|array|null $table = null): static;

    public function forKeyShareNoWait(string|array|null $table = null): static;

    public function forKeyShareSkipLocked(string|array|null $table = null): static;
}
