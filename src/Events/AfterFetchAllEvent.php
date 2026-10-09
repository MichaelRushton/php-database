<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterFetchAllEvent extends Event
{
    public function __construct(
        public BeforeFetchAllEvent $before_event,
        public array $rows
    ) {
        parent::__construct();
    }
}
