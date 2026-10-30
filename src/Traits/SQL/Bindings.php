<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;

trait Bindings
{
    public protected(set) array $bindings = [];

    public function mergeBindings(HasBindings $from): void
    {

        foreach ($from->bindings as $value) {
            $this->bindings[] = $value;
        }

    }
}
