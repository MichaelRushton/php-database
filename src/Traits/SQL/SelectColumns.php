<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait SelectColumns
{
    protected array $columns = [];

    public function columns(
        string|Stringable|int|float|bool|array|null $column,
        string|Stringable|int|float|bool|array|null ...$columns
    ): static {

        $column = \is_array($column) ? $column : [$column];

        foreach ($column as $alias => $c) {
            $this->columns[] = [SQL::identifier($c), \is_string($alias) ? " $alias" : ''];
        }

        foreach ($columns as $c) {
            $this->columns($c);
        }

        return $this;

    }

    protected function getColumns(): string
    {

        if (empty($this->columns)) {
            return '*';
        }

        foreach ($this->columns as [$column, $alias]) {

            $columns[] = $column . $alias;

            if ($column instanceof HasBindings) {
                $this->mergeBindings($column);
            }

        }

        return implode(', ', $columns ?? []);

    }
}
