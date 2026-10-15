<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

readonly class AfterBeginTransactionEvent extends Event
{
    public function __construct(
        public BeforeBeginTransactionEvent $before_event,
        public bool $success
    ) {
        parent::__construct();
    }
}
