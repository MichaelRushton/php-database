<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait OnConstraint
{
    protected string $on_constraint = '';

    public function onConstraint(string $constraint): static
    {

        $this->on_constraint = "ON CONSTRAINT $constraint";

        return $this;

    }
}
