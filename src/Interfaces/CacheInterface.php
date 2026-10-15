<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

use PDOStatement;

interface CacheInterface
{
    public function key(string $query): string;

    public function set(
        string $key,
        PDOStatement $stmt
    ): void;

    public function get(string $key): ?PDOStatement;

    public function clear(): void;
}
