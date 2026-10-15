<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL\Components\CTE;
use Stringable;

trait With
{
    protected array $with = [];
    protected string $recursive = '';

    public function with(
        string $name,
        string|Stringable|callable $stmt,
        ?callable $callback = null,
    ): static {

        if (\is_callable($stmt)) {
            $stmt($stmt = $this->connection()->select());
        }

        $this->with[] = $cte = new CTE($name, $stmt);

        if ($callback) {
            $callback($cte);
        }

        return $this;

    }

    public function recursive(): static
    {

        $this->recursive = ' RECURSIVE';

        return $this;

    }

    protected function getWith(): string
    {

        if (empty($this->with)) {
            return '';
        }

        $with = implode(', ', $this->with);

        foreach ($this->with as $cte) {

            if ($cte instanceof HasBindings) {
                $this->mergeBindings($cte);
            }

        }

        return "WITH$this->recursive $with";

    }
}
