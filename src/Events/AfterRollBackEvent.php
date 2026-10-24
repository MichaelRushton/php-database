<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterRollBackEvent extends Event
{
    public function __construct(
        public protected(set) BeforeRollBackEvent $before_event,
        public protected(set) bool $success
    ) {
        parent::__construct();
    }
}
