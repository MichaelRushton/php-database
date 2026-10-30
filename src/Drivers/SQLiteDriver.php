<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Interfaces\DriverInterface;

class SQLiteDriver implements DriverInterface
{
    public protected(set) string $dsn;
    public protected(set) null $username = null;
    public protected(set) null $password = null;
    public protected(set) string $savepoint = 'SAVEPOINT';
    public protected(set) string $roll_back_to = 'ROLLBACK TO';

    public function __construct(
        public protected(set) ?string $database = '',
        public protected(set) ?array $pdo_options = null
    ) {
        $this->dsn = "sqlite:$database";
    }
}
