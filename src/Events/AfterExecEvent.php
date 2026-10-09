<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterExecEvent extends Event
{
    public function __construct(
        public BeforeExecEvent $before_event,
        public int|false $count
    ) {
        parent::__construct();
    }
}
