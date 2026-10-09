<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterConnectEvent extends Event
{
    public function __construct(public BeforeConnectEvent $before_event)
    {
        parent::__construct();
    }
}
