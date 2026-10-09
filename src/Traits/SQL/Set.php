<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait Set
{
    protected array $set = [];

    public function set(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static {

        if (\is_array($column)) {
            return $this->setArray($column);
        }

        $this->set[$column] = SQL::value($value);

        return $this;

    }

    protected function setArray(array $columns): static
    {

        foreach ($columns as $column => $value) {
            $this->set($column, $value);
        }

        return $this;

    }

    protected function getSet(): string
    {

        if (empty($this->set)) {
            return '';
        }

        foreach ($this->set as $column => $value) {

            $set[] = "$column = $value";

            if ($value instanceof HasBindings) {
                $this->mergeBindings($value);
            }

        }

        return 'SET ' . implode(', ', $set ?? []);

    }
}
