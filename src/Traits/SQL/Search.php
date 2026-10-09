<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait Search
{
    protected string $search = '';

    protected function search(
        string $search,
        string|array $first_by,
        string $set
    ): static {

        $columns = implode(', ', (array) $first_by);

        $this->search = "SEARCH $search FIRST BY $columns SET $set";

        return $this;

    }

    public function searchBreadth(
        string|array $first_by,
        string $set
    ): static {
        return $this->search('BREADTH', $first_by, $set);
    }

    public function searchDepth(
        string|array $first_by,
        string $set
    ): static {
        return $this->search('DEPTH', $first_by, $set);
    }
}
