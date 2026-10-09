<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Partition
{
    protected array $partitions = [];

    public function partition(
        string|array $partition,
        string|array ...$partisions
    ): static {

        foreach ((array) $partition as $p) {
            $this->partitions[] = $p;
        }

        foreach ($partisions as $p) {
            $this->partition($p);
        }

        return $this;

    }

    protected function getPartition(): string
    {

        if (empty($this->partitions)) {
            return '';
        }

        return 'PARTITION (' . implode(', ', $this->partitions) . ')';

    }
}
