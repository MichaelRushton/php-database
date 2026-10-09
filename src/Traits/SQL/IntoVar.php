<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait IntoVar
{
    protected array $into_var = [];

    public function intoVar(
        string|array $name,
        string|array ...$names
    ): static {

        foreach ((array) $name as $n) {
            $this->into_var[] = "@$n";
        }

        foreach ($names as $name) {
            $this->intoVar($name);
        }

        return $this;

    }

    protected function getIntoVar(): string
    {

        if (empty($this->into_var)) {
            return '';
        }

        return 'INTO ' . implode(', ', $this->into_var);

    }
}
