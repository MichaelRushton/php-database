<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Quick
{
    protected string $quick = '';

    public function quick(): static
    {

        $this->quick = 'QUICK';

        return $this;

    }
}
