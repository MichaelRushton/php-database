<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait Using
{
    protected array $using = [];

    public function using(
        string|Stringable|array $table,
        string|Stringable|array ...$tables
    ): static {

        $table = \is_array($table) ? $table : [$table];

        foreach ($table as $alias => $t) {
            $this->using[] = [$t, \is_string($alias) ? " $alias" : ''];
        }

        foreach ($tables as $t) {
            $this->using($t);
        }

        return $this;

    }

    protected function getUsing(): string
    {

        if (empty($this->using)) {
            return '';
        }

        foreach ($this->using as [$table, $alias]) {

            $using[] = $table . $alias;

            if ($table instanceof HasBindings) {
                $this->mergeBindings($table);
            }

        }

        return 'USING ' . implode(', ', $using ?? []);

    }
}
