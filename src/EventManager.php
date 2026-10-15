<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use MichaelRushton\Database\Interfaces\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    protected array $events = [];

    public function listen(
        string $event,
        callable $callback
    ): static {

        $this->events[$event][] = $callback;

        return $this;

    }

    public function dispatch(object $event): void
    {

        foreach ($this->events[$event::class] ?? [] as $callback) {
            $callback($event);
        }

    }
}
