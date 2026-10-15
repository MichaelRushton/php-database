<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Statements\MySQL;

use MichaelRushton\Database\Interfaces\SQL\Statements\SelectInterface;
use Stringable;

interface MySQLSelectInterface extends SelectInterface
{
    public function highPriority(): static;

    public function straightJoinAll(): static;

    public function sqlSmallResult(): static;

    public function sqlBigResult(): static;

    public function sqlBufferResult(): static;

    public function sqlCalcFoundRows(): static;

    public function straightJoin(
        string|Stringable|array $table,
        string|Stringable|int|float|bool|array|callable|null $column1 = null,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $column2 = null
    ): static;

    public function naturalJoin(string|Stringable|array $table): static;

    public function naturalLeftJoin(string|Stringable|array $table): static;

    public function naturalRightJoin(string|Stringable|array $table): static;

    public function naturalFullJoin(string|Stringable|array $table): static;

    public function withRollup(): static;

    public function window(
        string $name,
        ?callable $callback = null,
    ): static;

    public function intersectAll(string|Stringable|callable|array $stmt): static;

    public function exceptAll(string|Stringable|callable|array $stmt): static;

    public function limit(
        int|string|Stringable $row_count,
        int|string|Stringable|null $offset = null
    ): static;

    public function intoOutfile(
        string $path,
        ?callable $callback = null
    ): static;

    public function intoDumpfile(string $path): static;

    public function intoVar(
        string|array $name,
        string|array ...$names
    ): static;

    public function forUpdate(string|array|null $table = null): static;

    public function forUpdateNoWait(string|array|null $table = null): static;

    public function forUpdateSkipLocked(string|array|null $table = null): static;

    public function forShare(string|array|null $table = null): static;

    public function forShareNoWait(string|array|null $table = null): static;

    public function forShareSkipLocked(string|array|null $table = null): static;

    public function lockInShareMode(): static;
}
