<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Lateral
{
    protected string $lateral = '';

    public function lateral(): static
    {

        $this->lateral = 'LATERAL';

        return $this;

    }
}
