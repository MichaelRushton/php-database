<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Distinct
{
    protected string $distinct = '';

    public function distinct(): static
    {

        $this->distinct = 'DISTINCT';

        return $this;

    }
}
