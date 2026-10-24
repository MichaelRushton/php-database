<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterExecEvent extends Event
{
    public function __construct(
        public protected(set) BeforeExecEvent $before_event,
        public protected(set) int|false $count
    ) {
        parent::__construct();
    }
}
