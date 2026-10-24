<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use Stringable;

trait RowCount
{
    protected int|string|Stringable $row_count = '';
    protected int|string|Stringable $offset = '';
}
