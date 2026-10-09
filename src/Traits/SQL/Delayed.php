<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Delayed
{
    protected string $delayed = '';

    public function delayed(): static
    {

        $this->delayed = 'DELAYED';

        return $this;

    }
}
