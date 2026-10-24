<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use PDOStatement;

class AfterPrepareEvent extends Event
{
    public function __construct(
        public protected(set) BeforePrepareEvent $before_event,
        public protected(set) PDOStatement|false $statement
    ) {
        parent::__construct();
    }
}
