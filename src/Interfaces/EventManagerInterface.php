<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

interface EventManagerInterface
{
    public function listen(
        string $event,
        callable $callback
    ): static;

    public function dispatch(object $event): static;
}
