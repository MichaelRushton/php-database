<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait HighPriority
{
    protected string $high_priority = '';

    public function highPriority(): static
    {

        $this->high_priority = 'HIGH_PRIORITY';

        return $this;

    }
}
