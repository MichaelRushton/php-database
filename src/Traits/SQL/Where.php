<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL\Components\Predicate;
use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Where as WhereComponent;
use Stringable;

trait Where
{
    protected array $where = [];

    public function where(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null,
        bool $or = false,
        bool $not = false,
        ?int $num_args = null
    ): static {

        if (\is_array($column)) {
            return $this->whereArray($column, $or, $not);
        }

        if (\is_callable($column)) {
            $column($where = new WhereComponent());
        } else {
            $where = new Predicate($column, $operator, $value, $num_args ??= \func_num_args());
        }

        $conjunction = empty($this->where) ? '' : ($or ? 'OR ' : 'AND ');

        $not = $not ? 'NOT ' : '';

        $this->where[] = [$conjunction . $not, $where];

        return $this;

    }

    protected function whereArray(
        array $expressions,
        bool $or,
        bool $not
    ): static {

        foreach ($expressions as $key => $expression) {
            $this->where($key, $expression, or: $or, not: $not, num_args: 2);
        }

        return $this;

    }

    public function orWhere(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static {
        return $this->where($column, $operator, $value, or: true, num_args: \func_num_args());
    }

    public function whereNot(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static {
        return $this->where($column, $operator, $value, not: true, num_args: \func_num_args());
    }

    public function orWhereNot(
        string|Stringable|int|float|bool|array|callable $column,
        string|Stringable|int|float|bool|array|null $operator = null,
        string|Stringable|int|float|bool|array|null $value = null
    ): static {
        return $this->where($column, $operator, $value, or: true, not: true, num_args: \func_num_args());
    }

    public function whereIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static {
        return $this->where($column, 'IN', $values);
    }

    public function orWhereIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static {
        return $this->where($column, 'IN', $values, or: true, num_args: 3);
    }

    public function whereNotIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static {
        return $this->where($column, 'IN', $values, not: true, num_args: 3);
    }

    public function orWhereNotIn(
        string|Stringable|int|float|bool $column,
        array $values
    ): static {
        return $this->where($column, 'IN', $values, or: true, not: true, num_args: 3);
    }

    public function whereBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static {
        return $this->where($column, 'BETWEEN', [$value1, $value2]);
    }

    public function orWhereBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static {
        return $this->where($column, 'BETWEEN', [$value1, $value2], or: true, num_args: 3);
    }

    public function whereNotBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static {
        return $this->where($column, 'BETWEEN', [$value1, $value2], not: true, num_args: 3);
    }

    public function orWhereNotBetween(
        string|Stringable|int|float $column,
        string|Stringable|int|float $value1,
        string|Stringable|int|float $value2
    ): static {
        return $this->where($column, 'BETWEEN', [$value1, $value2], or: true, not: true, num_args: 3);
    }

    public function whereNull(string|Stringable $column): static
    {
        return $this->where($column, 'IS', new Raw('NULL'), num_args: 3);
    }

    public function orWhereNull(string|Stringable $column): static
    {
        return $this->where($column, 'IS', new Raw('NULL'), or: true, num_args: 3);
    }

    public function whereNotNull(string|Stringable $column): static
    {
        return $this->where($column, 'IS', new Raw('NULL'), not: true, num_args: 3);
    }

    public function orWhereNotNull(string|Stringable $column): static
    {
        return $this->where($column, 'IS', new Raw('NULL'), or: true, not: true, num_args: 3);
    }

    protected function getWhere(): string
    {

        if (empty($this->where)) {
            return '';
        }

        foreach ($this->where as [$prefix, $predicate]) {

            $where[] = $prefix . $predicate;

            if ($predicate instanceof HasBindings) {
                $this->mergeBindings($predicate);
            }

        }

        return 'WHERE ' . implode(' ', $where ?? []);

    }
}
