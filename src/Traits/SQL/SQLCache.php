<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait SQLCache
{
    protected string $sql_cache = '';

    public function sqlCache(): static
    {

        $this->sql_cache = 'SQL_CACHE';

        return $this;

    }

    public function sqlNoCache(): static
    {

        $this->sql_cache = 'SQL_NO_CACHE';

        return $this;

    }
}
