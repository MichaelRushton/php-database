<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait Returning
{
    protected array $returning = [];

    public function returning(
        string|Stringable|int|float|bool|array|null $column = '*',
        string|Stringable|int|float|bool|array|null ...$columns
    ): static {

        $column = \is_array($column) ? $column : [$column];

        foreach ($column as $alias => $c) {
            $this->returning[] = [SQL::identifier($c), \is_string($alias) ? " $alias" : ''];
        }

        foreach ($columns as $c) {
            $this->returning($c);
        }

        return $this;

    }

    protected function getReturning(): string
    {

        if (empty($this->returning)) {
            return '';
        }

        foreach ($this->returning as [$column, $alias]) {

            $returning[] = $column . $alias;

            if ($column instanceof HasBindings) {
                $this->mergeBindings($column);
            }

        }

        return 'RETURNING ' . implode(', ', $returning ?? []);

    }
}
