<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Only
{
    protected string $only = '';

    public function only(): static
    {

        $this->only = 'ONLY';

        return $this;

    }
}
