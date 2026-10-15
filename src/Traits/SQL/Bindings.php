<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;

trait Bindings
{
    protected array $bindings = [];

    public function bindings(): array
    {
        return $this->bindings;
    }

    public function mergeBindings(HasBindings $from): void
    {

        foreach ($from->bindings() as $value) {
            $this->bindings[] = $value;
        }

    }
}
