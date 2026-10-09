<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use Throwable;

readonly class BeforeRollBackEvent extends Event
{
    public function __construct(
        public ConnectionInterface $connection,
        public Throwable $exception
    ) {
        parent::__construct();
    }
}
