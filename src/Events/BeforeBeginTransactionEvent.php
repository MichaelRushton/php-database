<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;
use MichaelRushton\Database\Interfaces\ConnectionInterface;

readonly class BeforeBeginTransactionEvent extends Event
{
    public function __construct(public ConnectionInterface $connection)
    {
        parent::__construct();
    }
}
