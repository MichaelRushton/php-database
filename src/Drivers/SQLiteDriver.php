<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Driver;

class SQLiteDriver extends Driver
{
    public function __construct(
        public protected(set) ?string $database = '',
        public protected(set) ?array $pdo_options = null
    ) {
        $this->dsn = "sqlite:$database";
    }
}
