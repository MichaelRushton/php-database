<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\HavingInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\Having as HavingTrait;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Having implements HavingInterface, HasBindings, Stringable
{
    use Bindings;
    use HavingTrait;
    use Pipe;
    use Through;
    use When;

    public function __toString(): string
    {

        if (empty($this->having)) {
            return '';
        }

        $this->bindings = [];

        foreach ($this->having as [$prefix, $predicate]) {

            $having[] = $prefix . $predicate;

            if ($predicate instanceof HasBindings) {
                $this->mergeBindings($predicate);
            }

        }

        $having = implode(' ', $having ?? []);

        return 1 === \count($this->having) ? $having : "($having)";

    }
}
