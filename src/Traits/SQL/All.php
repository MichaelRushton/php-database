<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait All
{
    protected string $all = '';

    public function all(): static
    {

        $this->all = 'ALL';

        return $this;

    }
}
