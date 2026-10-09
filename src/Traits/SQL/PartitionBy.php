<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait PartitionBy
{
    protected array $partition_by = [];

    public function partitionBy(
        string|Stringable|array $column,
        string|Stringable|array ...$columns
    ): static {

        $column = \is_array($column) ? $column : [$column];

        foreach ($column as $c) {
            $this->partition_by[] = $c;
        }

        foreach ($columns as $c) {
            $this->partitionBy($c);
        }

        return $this;

    }

    protected function getPartitionBy(): string
    {

        if (empty($this->partition_by)) {
            return '';
        }

        $partition_by = implode(', ', $this->partition_by);

        foreach ($this->partition_by as $column) {

            if ($column instanceof HasBindings) {
                $this->mergeBindings($column);
            }

        }

        return "PARTITION BY $partition_by";

    }
}
