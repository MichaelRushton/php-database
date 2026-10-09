<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\SQL\Components\Outfile;
use Stringable;

trait IntoOutfile
{
    protected string|Stringable $into_outfile = '';

    public function intoOutfile(
        string $path,
        ?callable $callback = null
    ): static {

        $this->into_outfile = $outfile = new Outfile($path);

        if ($callback) {
            $callback($outfile);
        }

        return $this;

    }

    protected function getIntoOutfile(): string
    {

        if ('' === $this->into_outfile) {
            return '';
        }

        return "INTO OUTFILE $this->into_outfile";

    }
}
