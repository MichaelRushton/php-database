<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\WindowInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\FrameSpec;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\PartitionBy;
use MichaelRushton\Database\Traits\SQL\SpecName;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Window implements WindowInterface, HasBindings, Stringable
{
    use Bindings;
    use FrameSpec;
    use OrderBy;
    use PartitionBy;
    use Pipe;
    use SpecName;
    use Through;
    use When;

    public function __construct(
        public readonly string $name
    ) {}

    protected function getSpec(): string
    {

        return implode(' ', array_filter([
            $this->spec_name,
            $this->getPartitionBy(),
            $this->getOrderBy(),
            $this->getFrameSpec(),
        ], '\strlen'));

    }

    public function __toString(): string
    {

        $this->bindings = [];

        return $this->name . ' AS (' . $this->getSpec() . ')';

    }
}
