<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait StraightJoin
{
    protected string $straight_join = '';

    public function straightJoinAll(): static
    {

        $this->straight_join = 'STRAIGHT_JOIN';

        return $this;

    }
}
