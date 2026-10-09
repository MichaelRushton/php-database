<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait SQLSmallResult
{
    protected string $sql_small_result = '';

    public function sqlSmallResult(): static
    {

        $this->sql_small_result = 'SQL_SMALL_RESULT';

        return $this;

    }
}
