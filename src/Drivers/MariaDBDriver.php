<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Driver;
use SensitiveParameter;

readonly class MariaDBDriver extends Driver
{
    public function __construct(
        public ?string $username = 'root',
        #[SensitiveParameter]
        public ?string $password = null,
        public ?string $host = '127.0.0.1',
        public ?int $port = 3306,
        public ?string $dbname = null,
        public ?string $unix_socket = null,
        public ?string $charset = null,
        public ?array $pdo_options = null
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
