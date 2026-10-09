<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Driver;
use SensitiveParameter;

readonly class PostgreSQLDriver extends Driver
{
    public function __construct(
        public ?string $username = 'postgres',
        #[SensitiveParameter]
        public ?string $password = null,
        public ?string $host = '127.0.0.1',
        public ?int $port = 5432,
        public ?string $dbname = 'postgres',
        public ?string $sslmode = 'prefer',
        public ?array $pdo_options = null
    ) {

        $this->dsn = 'pgsql:' . implode(';', array_filter([
            $host ? "host=$host" : '',
            $port ? "port=$port" : '',
            $dbname ? "dbname=$dbname" : '',
            $sslmode ? "sslmode=$sslmode" : '',
        ]));

    }
}
