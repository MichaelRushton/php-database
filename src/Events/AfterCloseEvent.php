<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterCloseEvent extends Event
{
    public function __construct(
        public protected(set) BeforeCloseEvent $before_event
    ) {
        parent::__construct();
    }
}
