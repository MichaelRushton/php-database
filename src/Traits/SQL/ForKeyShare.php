<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait ForKeyShare
{
    use ForLockOf;

    protected array $for_key_share = [];

    public function forKeyShare(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_key_share[] = ['FOR KEY SHARE', $this->getForLockOf($table, $tables)];

        return $this;

    }

    public function forKeyShareNoWait(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_key_share[] = ['FOR KEY SHARE', $this->getForLockOf($table, $tables), 'NOWAIT'];

        return $this;

    }

    public function forKeyShareSkipLocked(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_key_share[] = ['FOR KEY SHARE', $this->getForLockOf($table, $tables), 'SKIP LOCKED'];

        return $this;

    }

    protected function getForKeyShare(): string
    {

        if (empty($this->for_key_share)) {
            return '';
        }

        foreach ($this->for_key_share as $f) {
            $for_key_share[] = implode(' ', array_filter($f));
        }

        return implode(' ', $for_key_share ?? []);

    }
}
