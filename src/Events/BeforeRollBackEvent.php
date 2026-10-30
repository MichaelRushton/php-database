<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use Throwable;

class BeforeRollBackEvent extends Event
{
    public function __construct(
        public protected(set) ConnectionInterface $connection,
        public protected(set) ?Throwable $exception
    ) {
        parent::__construct();
    }
}
