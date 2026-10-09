<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use Stringable;

trait Into
{
    protected string $into = '';

    public function into(string|Stringable $table): static
    {

        $this->into = "INTO $table";

        return $this;

    }
}
