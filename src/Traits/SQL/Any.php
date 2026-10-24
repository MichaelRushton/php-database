<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Any
{
    protected string $any = '';

    public function any(): static
    {

        $this->any = 'ANY';

        return $this;

    }
}
