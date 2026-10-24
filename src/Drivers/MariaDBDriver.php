<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Driver;
use SensitiveParameter;

class MariaDBDriver extends Driver
{
    public function __construct(
        public protected(set) ?string $username = 'root',
        #[SensitiveParameter]
        public protected(set) ?string $password = null,
        public protected(set) ?string $host = '127.0.0.1',
        public protected(set) ?int $port = 3306,
        public protected(set) ?string $dbname = null,
        public protected(set) ?string $unix_socket = null,
        public protected(set) ?string $charset = null,
        public protected(set) ?array $pdo_options = null
    ) {

        $this->dsn = 'mysql:' . implode(';', array_filter([
            $host && !$unix_socket ? "host=$host" : '',
            $port && !$unix_socket ? "port=$port" : '',
            $dbname ? "dbname=$dbname" : '',
            $unix_socket ? "unix_socket=$unix_socket" : '',
            $charset ? "charset=$charset" : '',
        ]));

    }
}
