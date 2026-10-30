<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterCommitEvent extends Event
{
    public function __construct(
        public protected(set) BeforeCommitEvent $before_event,
        public protected(set) bool $success
    ) {
        parent::__construct();
    }
}
