<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL\Components\Upsert;
use Stringable;

trait OnConflict
{
    protected array $on_conflict = [];

    public function onConflictDoNothing(?callable $callback = null): static
    {

        $this->on_conflict[] = $upsert = new Upsert();

        if ($callback) {
            $callback($upsert);
        }

        return $this;

    }

    public function onConflictDoUpdateSet(
        string|array $column,
        string|Stringable|int|float|bool|callable|null $value = null,
        ?callable $callback = null
    ): static {

        if (\is_callable($value)) {
            [$value, $callback] = [null, $value];
        }

        $this->on_conflict[] = $upsert = new Upsert()->set($column, $value);

        if ($callback) {
            $callback($upsert);
        }

        return $this;

    }

    protected function getOnConflict(): string
    {

        if (empty($this->on_conflict)) {
            return '';
        }

        foreach ($this->on_conflict as $action) {

            $on_conflict[] = "ON CONFLICT $action";

            if ($action instanceof HasBindings) {
                $this->mergeBindings($action);
            }

        }

        return implode(' ', $on_conflict ?? []);

    }
}
