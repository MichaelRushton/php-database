<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\UpsertInterface;
use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\Bindings;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\OnConstraint;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\WhereIndex;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Upsert implements UpsertInterface, HasBindings, Stringable
{
    use Bindings;
    use Columns;
    use OnConstraint;
    use Pipe;
    use Set;
    use Through;
    use When;
    use Where;
    use WhereIndex;

    public function __toString(): string
    {

        $this->bindings = [];

        return implode(' ', array_filter([
            $this->getColumns(),
            $this->getWhereIndex(),
            $this->on_constraint,
            'DO',
            empty($this->set) ? 'NOTHING' : 'UPDATE',
            $this->getSet(),
            $this->getWhere(),
        ], '\strlen'));

    }
}
