<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait RowsExamined
{
    use RowCount;

    protected int|string|Stringable $rows_examined = '';

    public function rowsExamined(int|string|Stringable $row_count): static
    {

        $this->rows_examined = $row_count;

        return $this;

    }

    protected function getRowsExamined(): string
    {

        if ('' === $this->rows_examined) {
            return '';
        }

        $rows_examined = "ROWS EXAMINED $this->rows_examined";

        if ($this->rows_examined instanceof HasBindings) {
            $this->mergeBindings($this->rows_examined);
        }

        $prefix = '' === $this->row_count ? 'LIMIT ' : '';

        return $prefix . $rows_examined;

    }
}
