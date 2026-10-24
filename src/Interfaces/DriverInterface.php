<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

use PDO;

interface DriverInterface
{
    public function connect(): PDO;
}
