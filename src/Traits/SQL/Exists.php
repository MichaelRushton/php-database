<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Exists
{
    protected string $exists = '';

    public function exists(): static
    {

        $this->exists = 'EXISTS';

        return $this;

    }
}
