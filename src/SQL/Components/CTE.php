<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\CTEInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Cycle;
use MichaelRushton\Database\Traits\SQL\CycleRestrict;
use MichaelRushton\Database\Traits\SQL\Materialized;
use MichaelRushton\Database\Traits\SQL\Search;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class CTE implements CTEInterface, HasBindings, Stringable
{
    use Bindings;
    use Columns;
    use Cycle;
    use CycleRestrict;
    use Materialized;
    use Pipe;
    use Search;
    use Through;
    use When;

    public function __construct(
        public readonly string $name,
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
            $this->name,
            $this->getColumns(),
            'AS',
            $this->materialized,
            $this->getStmt(),
            $this->getCycleRestrict(),
            $this->search,
            $this->cycle,
        ], '\strlen'));

    }
}
