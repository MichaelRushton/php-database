<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait ForLockOf
{
    protected function getForLockOf(
        string|array|null $table,
        array $tables = []
    ): string {

        $tables = array_merge((array) $table, $tables);

        if (empty($tables)) {
            return '';
        }

        foreach ($tables as $ts) {

            foreach ((array) $ts as $t) {
                $of[] = $t;
            }

        }

        return 'OF ' . implode(', ', $of ?? []);

    }
}
