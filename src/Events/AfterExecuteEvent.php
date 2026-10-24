<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterExecuteEvent extends Event
{
    public function __construct(
        public protected(set) BeforeExecuteEvent $before_event,
        public protected(set) bool $success
    ) {
        parent::__construct();
    }
}
