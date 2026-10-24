<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterFetchColumnEvent extends Event
{
    public function __construct(
        public protected(set) BeforeFetchColumnEvent $before_event,
        public protected(set) mixed $value
    ) {
        parent::__construct();
    }
}
