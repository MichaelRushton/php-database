<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait WhereCurrentOf
{
    protected string $where_current_of = '';

    public function whereCurrentOf(string $cursor): static
    {

        $this->where_current_of = "WHERE CURRENT OF $cursor";

        return $this;

    }
}
