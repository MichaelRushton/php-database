<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\OnInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\On as OnTrait;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class On implements OnInterface, HasBindings, Stringable
{
    use Bindings;
    use OnTrait;
    use Pipe;
    use Through;
    use When;

    public function __toString(): string
    {

        if (empty($this->on)) {
            return '';
        }

        $this->bindings = [];

        foreach ($this->on as [$prefix, $predicate]) {

            $on[] = $prefix . $predicate;

            if ($predicate instanceof HasBindings) {
                $this->mergeBindings($predicate);
            }

        }

        $on = implode(' ', $on ?? []);

        return 1 === \count($this->on) ? $on : "($on)";

    }
}
