<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;
use PDOStatement;

readonly class AfterPrepareEvent extends Event
{
    public function __construct(
        public BeforePrepareEvent $before_event,
        public PDOStatement|false $statement
    ) {
        parent::__construct();
    }
}
