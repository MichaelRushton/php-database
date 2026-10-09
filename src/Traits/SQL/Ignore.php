<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Ignore
{
    protected string $ignore = '';

    public function ignore(): static
    {

        $this->ignore = 'IGNORE';

        return $this;

    }
}
