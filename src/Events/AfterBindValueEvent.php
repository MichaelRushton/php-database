<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterBindValueEvent extends Event
{
    public function __construct(
        public protected(set) BeforeBindValueEvent $before_event,
        public protected(set) bool $success
    ) {
        parent::__construct();
    }
}
