<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL;

interface HasBindings
{
    public array $bindings { get; }

    public function mergeBindings(HasBindings $from): void;
}
