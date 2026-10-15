<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Components;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use MichaelRushton\Database\Traits\SQL\Bindings;
use Stringable;

class Predicate implements HasBindings, Stringable
{
    use Bindings;

    protected string|Stringable|int|float $column;
    protected string $operator = '';
    protected string|Stringable|array $value = '';

    public function __construct(
        string|Stringable|int|float|bool $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null,
        ?int $num_args = null
    ) {

        $this->column = SQL::identifier($column);

        if (2 === $num_args ??= \func_num_args()) {
            [$operator, $value] = [null, $operator];
        }

        if ($num_args > 1) {

            $this->operator = $operator ?? '=';

            $this->value = SQL::value($value);

        }

    }

    protected function value(): string
    {

        return match (true) {
            !\is_array($this->value) => (string) $this->value,
            'BETWEEN' === strtoupper($this->operator) => implode(' AND ', $this->value),
            default => '(' . implode(', ', $this->value) . ')',
        };

    }

    public function __toString(): string
    {

        $this->bindings = [];

        $predicate = "$this->column $this->operator " . $this->value();

        foreach ([$this->column, $this->value] as $part) {

            $part = \is_array($part) ? $part : [$part];

            foreach ($part as $p) {

                if ($p instanceof HasBindings) {
                    $this->mergeBindings($p);
                }

            }

        }

        return trim($predicate);

    }
}
