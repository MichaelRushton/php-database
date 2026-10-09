<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL;

interface HasBindings
{
    public function bindings(): array;

    public function mergeBindings(HasBindings $from): void;
}
