<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\Components\OutfileInterface;
use MichaelRushton\Database\SQL;
use MichaelRushton\Database\Traits\Pipe;
use MichaelRushton\Database\Traits\SQL\CharacterSet;
use MichaelRushton\Database\Traits\SQL\Fields;
use MichaelRushton\Database\Traits\SQL\Lines;
use MichaelRushton\Database\Traits\Through;
use MichaelRushton\Database\Traits\When;
use Stringable;

class Outfile implements OutfileInterface, Stringable
{
    use CharacterSet;
    use Fields;
    use Lines;
    use Pipe;
    use Through;
    use When;

    public function __construct(protected string $path)
    {
        $this->path = SQL::escape($path);
    }

    public function __toString(): string
    {

        return implode(' ', array_filter([
            "'$this->path'",
            $this->character_set,
            $this->getFields(),
            $this->getLines(),
        ], '\strlen'));

    }
}
