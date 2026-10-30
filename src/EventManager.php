<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use InvalidArgumentException;
use MichaelRushton\Database\Interfaces\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    protected array $listeners = [];

    public function listen(
        string $event,
        callable $callback
    ): static {

        if (!class_exists($event)) {
            throw new InvalidArgumentException();
        }

        $this->listeners[$event][] = $callback;

        return $this;

    }

    public function dispatch(object $event): static
    {

        foreach ($this->listeners[$event::class] ?? [] as $callback) {
            $callback($event);
        }

        return $this;

    }
}
