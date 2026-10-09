<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait ForShare
{
    use ForLockOf;

    protected array $for_share = [];

    public function forShare(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_share[] = ['FOR SHARE', $this->getForLockOf($table, $tables)];

        return $this;

    }

    public function forShareNoWait(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_share[] = ['FOR SHARE', $this->getForLockOf($table, $tables), 'NOWAIT'];

        return $this;

    }

    public function forShareSkipLocked(
        string|array|null $table = null,
        string|array ...$tables
    ): static {

        $this->for_share[] = ['FOR SHARE', $this->getForLockOf($table, $tables), 'SKIP LOCKED'];

        return $this;

    }

    protected function getForShare(): string
    {

        if (empty($this->for_share)) {
            return '';
        }

        foreach ($this->for_share as $f) {
            $for_share[] = implode(' ', array_filter($f));
        }

        return implode(' ', $for_share ?? []);

    }
}
