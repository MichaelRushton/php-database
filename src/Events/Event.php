<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

readonly class Event
{
    public float $time;

    public function __construct()
    {
        $this->time = microtime(true);
    }
}
