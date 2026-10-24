<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait IndexHint
{
    protected array $index_hint = [];

    protected function index(
        string $type,
        string|array|null $index,
        array $indexes = [],
        string $for = ''
    ): static {

        $index = (array) $index;

        foreach ($indexes as $is) {

            foreach ((array) $is as $i) {
                $index[] = $i;
            }

        }

        $index = implode(', ', $index);

        $this->index_hint[] = "$type INDEX$for ($index)";

        return $this;

    }

    public function useIndex(
        string|array|null $index = null,
        string|array ...$indexes
    ): static {
        return $this->index('USE', $index, $indexes);
    }

    public function useIndexForOrderBy(
        string|array|null $index = null,
        string|array ...$indexes
    ): static {
        return $this->index('USE', $index, $indexes, ' FOR ORDER BY');
    }

    public function useIndexForGroupBy(
        string|array|null $index = null,
        string|array ...$indexes
    ): static {
        return $this->index('USE', $index, $indexes, ' FOR GROUP BY');
    }

    public function ignoreIndex(
        string|array $index,
        string|array ...$indexes
    ): static {
        return $this->index('IGNORE', $index, $indexes);
    }

    public function ignoreIndexForOrderBy(
        string|array $index,
        string|array ...$indexes
    ): static {
        return $this->index('IGNORE', $index, $indexes, ' FOR ORDER BY');
    }

    public function ignoreIndexForGroupBy(
        string|array $index,
        string|array ...$indexes
    ): static {
        return $this->index('IGNORE', $index, $indexes, ' FOR GROUP BY');
    }

    public function forceIndex(
        string|array $index,
        string|array ...$indexes
    ): static {
        return $this->index('FORCE', $index, $indexes);
    }

    public function forceIndexForOrderBy(
        string|array $index,
        string|array ...$indexes
    ): static {
        return $this->index('FORCE', $index, $indexes, ' FOR ORDER BY');
    }

    public function forceIndexForGroupBy(
        string|array $index,
        string|array ...$indexes
    ): static {
        return $this->index('FORCE', $index, $indexes, ' FOR GROUP BY');
    }

    protected function getIndexHint(): string
    {
        return implode(', ', $this->index_hint);
    }
}
