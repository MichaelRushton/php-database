<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits;

trait When
{
    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static {

        if ($value && $if_true) {
            $if_true($this, $value);
        } elseif (!$value && $if_false) {
            $if_false($this, $value);
        }

        return $this;

    }
}
