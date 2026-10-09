<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use MichaelRushton\Database\Interfaces\DriverInterface;
use PDO;

abstract readonly class Driver implements DriverInterface
{
    public string $dsn;

    public function connect(): PDO
    {
        return PDO::connect($this->dsn, $this->username ?? null, $this->password ?? null, $this->pdo_options ?? null);
    }
}
