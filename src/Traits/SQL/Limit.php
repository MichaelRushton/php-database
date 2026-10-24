<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait Limit
{
    use RowCount;

    public function limit(
        int|string|Stringable $row_count,
        int|string|Stringable|null $offset = null
    ): static {

        $this->row_count = $row_count;

        $this->offset = $offset ?? '';

        return $this;

    }

    protected function getOffset(): string
    {

        if ('' === $this->offset) {
            return '';
        }

        $offset = " OFFSET $this->offset";

        if ($this->offset instanceof HasBindings) {
            $this->mergeBindings($this->offset);
        }

        return $offset;

    }

    protected function getLimit(): string
    {

        if ('' === $this->row_count || '' !== ($this->with_ties ?? '')) {
            return '';
        }

        $limit = "LIMIT $this->row_count";

        if ($this->row_count instanceof HasBindings) {
            $this->mergeBindings($this->row_count);
        }

        return $limit . $this->getOffset();

    }
}
