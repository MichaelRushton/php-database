<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use MichaelRushton\Database\SQL;
use Stringable;

trait OnDuplicateKeyUpdate
{
    protected array $on_duplicate_key_update = [];

    public function onDuplicateKeyUpdate(
        string|array $column,
        string|Stringable|int|float|bool|null $value = null
    ): static {

        if (\is_array($column)) {
            return $this->onDuplicateKeyUpdateArray($column);
        }

        $this->on_duplicate_key_update[$column] = SQL::value($value);

        return $this;

    }

    protected function onDuplicateKeyUpdateArray(array $columns): static
    {

        foreach ($columns as $column => $value) {
            $this->onDuplicateKeyUpdate($column, $value);
        }

        return $this;

    }

    protected function getOnDuplicateKeyUpdate(): string
    {

        if (empty($this->on_duplicate_key_update)) {
            return '';
        }

        foreach ($this->on_duplicate_key_update as $column => $value) {

            $on_duplicate_key_update[] = "$column = $value";

            if ($value instanceof HasBindings) {
                $this->mergeBindings($value);
            }

        }

        return 'ON DUPLICATE KEY UPDATE ' . implode(', ', $on_duplicate_key_update ?? []);

    }
}
