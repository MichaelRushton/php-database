<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait From
{
    protected array $from = [];

    public function from(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static {

        $table = \is_array($table) ? $table : [$table];

        foreach ($table as $alias => $t) {
            $this->from[] = [SQL::identifier($t), \is_string($alias) ? " $alias" : ''];
        }

        foreach ($tables as $t) {
            $this->from($t);
        }

        return $this;

    }

    protected function getFrom(): string
    {

        if (empty($this->from)) {
            return '';
        }

        foreach ($this->from as [$table, $alias]) {

            $from[] = $table . $alias;

            if ($table instanceof HasBindings) {
                $this->mergeBindings($table);
            }

        }

        return 'FROM ' . implode(', ', $from ?? []);

    }
}
