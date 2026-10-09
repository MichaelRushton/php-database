<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\SQL\Bindings;
use Stringable;

class Raw implements HasBindings, Stringable
{
    use Bindings;

    public function __construct(
        public readonly string $expression,
        string|int|float|bool|array|null $bindings = []
    ) {

        $bindings = \is_array($bindings) ? $bindings : [$bindings];

        foreach ($bindings as $value) {
            $this->bindings[] = $value;
        }

    }

    public function __toString(): string
    {
        return $this->expression;
    }
}
