<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait Select
{
    protected string|Stringable $select = '';

    public function select(string|Stringable|callable $stmt): static
    {

        if (\is_callable($stmt)) {
            $stmt($stmt = $this->connection()->select());
        }

        $this->select = $stmt;

        return $this;

    }

    protected function getSelect(): string
    {

        $select = (string) $this->select;

        if ($this->select instanceof HasBindings) {
            $this->mergeBindings($this->select);
        }

        return $select;

    }
}
