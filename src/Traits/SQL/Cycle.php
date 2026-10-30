<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Cycle
{
    protected string $cycle = '';

    public function cycle(
        string|array $columns,
        string $set = 'is_cycle',
        string $using = 'path'
    ): static {

        $columns = implode(', ', (array) $columns);

        $this->cycle = "CYCLE $columns SET $set USING $using";

        return $this;

    }
}
