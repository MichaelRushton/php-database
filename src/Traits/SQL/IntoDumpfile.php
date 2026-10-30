<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait IntoDumpfile
{
    protected string $into_dumpfile = '';

    public function intoDumpfile(string $path): static
    {

        $path = str_replace("'", "''", $path);

        $this->into_dumpfile = "INTO DUMPFILE '$path'";

        return $this;

    }
}
