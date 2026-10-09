<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;

readonly class AfterFetchColumnEvent extends Event
{
    public function __construct(
        public BeforeFetchColumnEvent $before_event,
        public mixed $value
    ) {
        parent::__construct();
    }
}
