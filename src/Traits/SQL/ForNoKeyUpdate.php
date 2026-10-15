<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait ForNoKeyUpdate
{
    use ForLockOf;

    protected array $for_no_key_update = [];

    public function forNoKeyUpdate(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_no_key_update[] = ['FOR NO KEY UPDATE', $this->getForLockOf($table, $tables)];

        return $this;

    }

    public function forNoKeyUpdateNoWait(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_no_key_update[] = ['FOR NO KEY UPDATE', $this->getForLockOf($table, $tables), 'NOWAIT'];

        return $this;

    }

    public function forNoKeyUpdateSkipLocked(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_no_key_update[] = ['FOR NO KEY UPDATE', $this->getForLockOf($table, $tables), 'SKIP LOCKED'];

        return $this;

    }

    protected function getForNoKeyUpdate(): string
    {

        if (empty($this->for_no_key_update)) {
            return '';
        }

        foreach ($this->for_no_key_update as $f) {
            $for_no_key_update[] = implode(' ', array_filter($f));
        }

        return implode(' ', $for_no_key_update ?? []);

    }
}
