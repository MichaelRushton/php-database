<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterExecuteEvent extends Event
{
    public function __construct(
        public BeforeExecuteEvent $before_event,
        public bool $success
    ) {
        parent::__construct();
    }
}
