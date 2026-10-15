<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

readonly class AfterCloseEvent extends Event
{
    public function __construct(public BeforeCloseEvent $before_event)
    {
        parent::__construct();
    }
}
