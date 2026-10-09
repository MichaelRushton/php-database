<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Alias
{
    protected string $alias = '';

    public function as(string $alias): static
    {

        $this->alias = $alias;

        return $this;

    }
}
