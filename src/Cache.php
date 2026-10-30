<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use MichaelRushton\Database\Interfaces\CacheInterface;
use PDOStatement;

class Cache implements CacheInterface
{
    protected array $cache = [];

    public function key(string $query): string
    {
        return hash('xxh128', $query);
    }

    public function set(
        string $key,
        PDOStatement $stmt
    ): void {
        $this->cache[$key] = $stmt;
    }

    public function get(string $key): ?PDOStatement
    {
        return $this->cache[$key] ?? null;
    }

    public function clear(): void
    {
        $this->cache = [];
    }
}
