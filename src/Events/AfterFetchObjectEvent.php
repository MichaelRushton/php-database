<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterFetchObjectEvent extends Event
{
    public function __construct(
        public BeforeFetchObjectEvent $before_event,
        public object|false $object
    ) {
        parent::__construct();
    }
}
