<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\ConnectionInterface;

class BeforeCommitEvent extends Event
{
    public function __construct(
        public protected(set) ConnectionInterface $connection
    ) {
        parent::__construct();
    }
}
