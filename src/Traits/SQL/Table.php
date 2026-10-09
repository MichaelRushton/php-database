<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait Table
{
    protected array $table = [];

    public function table(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static {

        $table = \is_array($table) ? $table : [$table];

        foreach ($table as $alias => $t) {
            $this->table[] = [SQL::identifier($t), \is_string($alias) ? " $alias" : ''];
        }

        foreach ($tables as $t) {
            $this->table($t);
        }

        return $this;

    }

    protected function getTable(): string
    {

        if (empty($this->table)) {
            return '';
        }

        foreach ($this->table as [$table, $alias]) {

            $tables[] = $table . $alias;

            if ($table instanceof HasBindings) {
                $this->mergeBindings($table);
            }

        }

        return implode(', ', $tables ?? []);

    }
}
