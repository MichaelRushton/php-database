<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

use MichaelRushton\Database\Interfaces\Events\EventInterface;

interface EventManagerInterface
{
    public function listen(
        string $event,
        callable $callback
    ): static;

    public function dispatch(EventInterface $event): static;
}
