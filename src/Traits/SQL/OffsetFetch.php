<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait OffsetFetch
{
    use RowCount;
    use WithTies;

    public function offsetFetch(
        int|string|Stringable $offset,
        int|string|Stringable $row_count
    ): static {

        $this->row_count = $row_count;

        $this->offset = $offset;

        return $this;

    }

    protected function getOffsetFetch(): string
    {

        if ('' === $this->row_count || '' === $this->offset) {
            return '';
        }

        $suffix = $this->with_ties ?: ' ONLY';

        $offset_fetch = "OFFSET $this->offset ROWS FETCH NEXT $this->row_count ROWS$suffix";

        foreach ([$this->offset, $this->row_count] as $part) {

            if ($part instanceof HasBindings) {
                $this->mergeBindings($part);
            }

        }

        return $offset_fetch;

    }
}
