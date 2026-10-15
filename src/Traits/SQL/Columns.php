<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Columns
{
    protected array $columns = [];

    public function columns(
        string|array $column,
        string|array ...$columns
    ): static {

        foreach ((array) $column as $c) {
            $this->columns[] = $c;
        }

        foreach ($columns as $c) {
            $this->columns($c);
        }

        return $this;

    }

    protected function getColumns(): string
    {

        if (empty($this->columns)) {
            return '';
        }

        return '(' . implode(', ', $this->columns) . ')';

    }
}
