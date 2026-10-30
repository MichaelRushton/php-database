<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterConnectEvent extends Event
{
    public function __construct(
        public protected(set) BeforeConnectEvent $before_event
    ) {
        parent::__construct();
    }
}
