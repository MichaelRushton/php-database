<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits;

trait Pipe
{
    public function pipe(callable $callback): mixed
    {
        return $callback($this);
    }
}
