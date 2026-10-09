<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterCommitEvent extends Event
{
    public function __construct(
        public BeforeCommitEvent $before_event,
        public bool $success
    ) {
        parent::__construct();
    }
}
