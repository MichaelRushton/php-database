<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\SQL;

trait Lines
{
    protected array $lines = [];

    public function linesStartingBy(string $string): static
    {

        $string = SQL::escape($string);

        $this->lines[0] = "STARTING BY '$string'";

        return $this;

    }

    public function linesTerminatedBy(string $string): static
    {

        $string = SQL::escape($string);

        $this->lines[1] = "TERMINATED BY '$string'";

        return $this;

    }

    protected function getLines(): string
    {

        if (empty($this->lines)) {
            return '';
        }

        ksort($this->lines);

        return 'LINES ' . implode(' ', $this->lines);

    }
}
