<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use PDOStatement;

class AfterQueryEvent extends Event
{
    public function __construct(
        public protected(set) BeforeQueryEvent $before_event,
        public protected(set) PDOStatement|false $statement
    ) {
        parent::__construct();
    }
}
