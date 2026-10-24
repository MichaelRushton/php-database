<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait WithTies
{
    protected string $with_ties = '';

    public function withTies(): static
    {

        $this->with_ties = ' WITH TIES';

        return $this;

    }
}
