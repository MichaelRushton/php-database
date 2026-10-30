<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class AfterFetchAllEvent extends Event
{
    public function __construct(
        public protected(set) BeforeFetchAllEvent $before_event,
        public protected(set) array $rows
    ) {
        parent::__construct();
    }
}
