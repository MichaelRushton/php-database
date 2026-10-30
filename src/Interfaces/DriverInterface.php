<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

interface DriverInterface
{
    public string $dsn { get; }
    public ?string $username { get; }
    public ?string $password { get; }
    public ?array $pdo_options { get; }
    public string $savepoint { get; }
    public string $roll_back_to { get; }
}
