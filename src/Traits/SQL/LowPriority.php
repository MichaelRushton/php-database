<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait LowPriority
{
    protected string $low_priority = '';

    public function lowPriority(): static
    {

        $this->low_priority = 'LOW_PRIORITY';

        return $this;

    }
}
