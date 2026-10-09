<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait Output
{
    protected array $output = [];

    public function output(
        string|Stringable|int|float|bool|array|null $column,
        string|Stringable|int|float|bool|array|null ...$columns
    ): static {

        $column = \is_array($column) ? $column : [$column];

        foreach ($column as $alias => $c) {
            $this->output[] = [SQL::identifier($c), \is_string($alias) ? " $alias" : ''];
        }

        foreach ($columns as $c) {
            $this->output($c);
        }

        return $this;

    }

    protected function getOutput(): string
    {

        if (empty($this->output)) {
            return '';
        }

        foreach ($this->output as [$column, $alias]) {

            $output[] = $column . $alias;

            if ($column instanceof HasBindings) {
                $this->mergeBindings($column);
            }

        }

        return 'OUTPUT ' . implode(', ', $output ?? []);

    }
}
