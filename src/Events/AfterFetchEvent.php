<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterFetchEvent extends Event
{
    public function __construct(
        public BeforeFetchEvent $before_event,
        public mixed $row
    ) {
        parent::__construct();
    }
}
