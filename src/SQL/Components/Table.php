<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\TableInterface;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Alias;
use MichaelRushton\Database\Traits\SQL\ForPortionOf;
use MichaelRushton\Database\Traits\SQL\IndexHint;
use MichaelRushton\Database\Traits\SQL\Only;
use MichaelRushton\Database\Traits\SQL\Partition;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Table implements TableInterface, Stringable
{
    use Alias;
    use ForPortionOf;
    use IndexHint;
    use Only;
    use Partition;
    use Pipe;
    use Through;
    use When;

    public function __construct(
        public readonly string $name
    ) {}

    public function __toString(): string
    {

        return implode(' ', array_filter([
            $this->only,
            $this->name,
            $this->getPartition(),
            $this->for_portion_of,
            $this->alias,
            $this->getIndexHint(),
        ]));

    }
}
