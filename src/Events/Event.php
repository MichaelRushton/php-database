<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\Events\EventInterface;

class Event implements EventInterface
{
    public protected(set) float $time;

    public function __construct()
    {
        $this->time = microtime(true);
    }
}
