<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Components;

use DateTimeInterface;

interface TableInterface
{
    public function only(): static;

    public function partition(
        string|array $partition,
        string|array ...$partitions
    ): static;

    public function forPortionOf(
        string $date_period,
        string|DateTimeInterface $datetime_start,
        string|DateTimeInterface $datetime_end
    ): static;

    public function as(string $alias): static;

    public function useIndex(
        string|array|null $index = null,
        string|array ...$indexes
    ): static;

    public function useIndexForOrderBy(
        string|array|null $index = null,
        string|array ...$indexes
    ): static;

    public function useIndexForGroupBy(
        string|array|null $index = null,
        string|array ...$indexes
    ): static;

    public function ignoreIndex(
        string|array $index,
        string|array ...$indexes
    ): static;

    public function ignoreIndexForOrderBy(
        string|array $index,
        string|array ...$indexes
    ): static;

    public function ignoreIndexForGroupBy(
        string|array $index,
        string|array ...$indexes
    ): static;

    public function forceIndex(
        string|array $index,
        string|array ...$indexes
    ): static;

    public function forceIndexForOrderBy(
        string|array $index,
        string|array ...$indexes
    ): static;

    public function forceIndexForGroupBy(
        string|array $index,
        string|array ...$indexes
    ): static;

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;
}
