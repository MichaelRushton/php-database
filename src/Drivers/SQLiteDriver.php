<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Driver;

readonly class SQLiteDriver extends Driver
{
    public function __construct(
        public ?string $database = '',
        public ?array $pdo_options = null
    ) {
        $this->dsn = "sqlite:$database";
    }
}
