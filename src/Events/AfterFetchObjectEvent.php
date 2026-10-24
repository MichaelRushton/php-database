<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterFetchObjectEvent extends Event
{
    public function __construct(
        public protected(set) BeforeFetchObjectEvent $before_event,
        public protected(set) object|false $object
    ) {
        parent::__construct();
    }
}
