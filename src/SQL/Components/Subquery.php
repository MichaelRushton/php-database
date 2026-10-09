<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\SubqueryInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Alias;
use MichaelRushton\Database\Traits\SQL\All;
use MichaelRushton\Database\Traits\SQL\Any;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Exists;
use MichaelRushton\Database\Traits\SQL\In;
use MichaelRushton\Database\Traits\SQL\Lateral;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Subquery implements SubqueryInterface, HasBindings, Stringable
{
    use Alias;
    use All;
    use Any;
    use Bindings;
    use Columns;
    use Exists;
    use In;
    use Lateral;
    use Pipe;
    use Through;
    use When;

    public function __construct(
        public readonly string|Stringable $stmt
    ) {}

    protected function getStmt(): string
    {

        $stmt = "($this->stmt)";

        if ($this->stmt instanceof HasBindings) {
            $this->mergeBindings($this->stmt);
        }

        return $stmt;

    }

    public function __toString(): string
    {

        $this->bindings = [];

        return implode(' ', array_filter([
            $this->all,
            $this->any,
            $this->exists,
            $this->in,
            $this->lateral,
            $this->getStmt(),
            $this->alias,
            $this->getColumns(),
        ], '\strlen'));

    }
}
