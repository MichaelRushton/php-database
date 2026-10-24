<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\Connection;

use MichaelRushton\Database\Events\AfterBindValueEvent;
use MichaelRushton\Database\Events\BeforeBindValueEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDO;
use PDOStatement;

class BindValue
{
    public function handle(
        ConnectionInterface $connection,
        PDOStatement $stmt,
        string $query,
        string|int $param,
        mixed $value
    ): bool {

        $before_event = new BeforeBindValueEvent($connection, $stmt, $query, $param, $value);

        $connection->event_manager->dispatch($before_event);

        $success = $stmt->bindValue(\is_string($param) ? $param : $param + 1, $value, match (\gettype($value)) {
            'integer' => PDO::PARAM_INT,
            'boolean' => PDO::PARAM_BOOL,
            'NULL' => PDO::PARAM_NULL,
            'resource' => PDO::PARAM_LOB,
            default => PDO::PARAM_STR,
        });

        $connection->event_manager->dispatch(new AfterBindValueEvent($before_event, $success));

        return $success;

    }
}
