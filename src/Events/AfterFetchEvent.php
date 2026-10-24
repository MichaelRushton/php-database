<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterFetchEvent extends Event
{
    public function __construct(
        public protected(set) BeforeFetchEvent $before_event,
        public protected(set) mixed $row
    ) {
        parent::__construct();
    }
}
