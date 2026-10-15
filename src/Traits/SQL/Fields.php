<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\SQL;

trait Fields
{
    protected array $fields = [];

    public function fieldsTerminatedBy(string $string): static
    {

        $string = SQL::escape($string);

        $this->fields[0] = "TERMINATED BY '$string'";

        return $this;

    }

    public function fieldsEnclosedBy(string $char): static
    {

        $char = SQL::escape($char);

        $this->fields[1] = "ENCLOSED BY '$char'";

        return $this;

    }

    public function fieldsOptionallyEnclosedBy(string $char): static
    {

        $char = SQL::escape($char);

        $this->fields[1] = "OPTIONALLY ENCLOSED BY '$char'";

        return $this;

    }

    public function fieldsEscapedBy(string $char): static
    {

        $char = SQL::escape($char);

        $this->fields[2] = "ESCAPED BY '$char'";

        return $this;

    }

    protected function getFields(): string
    {

        if (empty($this->fields)) {
            return '';
        }

        ksort($this->fields);

        return 'FIELDS ' . implode(' ', $this->fields);

    }
}
