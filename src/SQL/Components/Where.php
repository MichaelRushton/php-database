<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\WhereInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\Where as WhereTrait;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Where implements WhereInterface, HasBindings, Stringable
{
    use Bindings;
    use Pipe;
    use Through;
    use WhereTrait;
    use When;

    public function __toString(): string
    {

        if (empty($this->where)) {
            return '';
        }

        $this->bindings = [];

        foreach ($this->where as [$prefix, $predicate]) {

            $where[] = $prefix . $predicate;

            if ($predicate instanceof HasBindings) {
                $this->mergeBindings($predicate);
            }

        }

        $where = implode(' ', $where ?? []);

        return 1 === \count($this->where) ? $where : "($where)";

    }
}
