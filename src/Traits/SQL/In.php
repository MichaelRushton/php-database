<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait In
{
    protected string $in = '';

    public function in(): static
    {

        $this->in = 'IN';

        return $this;

    }
}
