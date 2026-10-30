<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait SQLCalcFoundRows
{
    protected string $sql_calc_found_rows = '';

    public function sqlCalcFoundRows(): static
    {

        $this->sql_calc_found_rows = 'SQL_CALC_FOUND_ROWS';

        return $this;

    }
}
