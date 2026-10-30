<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\ConnectionInterface;

class BeforeExecEvent extends Event
{
    public function __construct(
        public protected(set) ConnectionInterface $connection,
        public protected(set) string $statement
    ) {
        parent::__construct();
    }
}
