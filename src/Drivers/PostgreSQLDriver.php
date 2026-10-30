<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Interfaces\DriverInterface;
use SensitiveParameter;

class PostgreSQLDriver implements DriverInterface
{
    public protected(set) string $dsn;
    public protected(set) string $savepoint = 'SAVEPOINT';
    public protected(set) string $roll_back_to = 'ROLLBACK TO';

    public function __construct(
        public protected(set) ?string $username = 'postgres',
        #[SensitiveParameter]
        public protected(set) ?string $password = null,
        public protected(set) ?string $host = '127.0.0.1',
        public protected(set) ?int $port = 5432,
        public protected(set) ?string $dbname = 'postgres',
        public protected(set) ?string $sslmode = 'prefer',
        public protected(set) ?array $pdo_options = null
    ) {

        $this->dsn = 'pgsql:' . implode(';', array_filter([
            $host ? "host=$host" : '',
            $port ? "port=$port" : '',
            $dbname ? "dbname=$dbname" : '',
            $sslmode ? "sslmode=$sslmode" : '',
        ]));

    }
}
