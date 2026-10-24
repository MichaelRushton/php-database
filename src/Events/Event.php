<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

class Event
{
    public protected(set) float $time;

    public function __construct()
    {
        $this->time = microtime(true);
    }
}
