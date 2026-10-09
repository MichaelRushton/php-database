<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use DateTimeInterface;

trait ForPortionOf
{
    protected string $for_portion_of = '';

    public function forPortionOf(
        string $date_period,
        string|DateTimeInterface $datetime_start,
        string|DateTimeInterface $datetime_end
    ): static {

        foreach ([&$datetime_start, &$datetime_end] as &$datetime) {

            if ($datetime instanceof DateTimeInterface) {
                $datetime = $datetime->format('Y-m-d H:i:s');
            }

        }

        $this->for_portion_of = "FOR PORTION OF $date_period FROM '$datetime_start' TO '$datetime_end'";

        return $this;

    }
}
