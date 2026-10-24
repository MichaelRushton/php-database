<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\Components\SubqueryInterface;
use MichaelRushton\Database\SQL\Components\Subquery;

trait ToSubquery
{
    public function subquery(): SubqueryInterface
    {
        return new Subquery($this);
    }
}
