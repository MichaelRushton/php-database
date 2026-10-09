<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\Connection;

use MichaelRushton\Database\Events\AfterFetchAllEvent;
use MichaelRushton\Database\Events\BeforeFetchAllEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDO;
use PDOStatement;

class FetchAll
{
    public function handle(
        ConnectionInterface $connection,
        PDOStatement $stmt,
        string $query,
        array|string|int|float|bool|null $params,
        int $mode = PDO::FETCH_DEFAULT,
        mixed ...$args
    ): array|false {

        $before_event = new BeforeFetchAllEvent($connection, $stmt, $query, $params, $mode, $args);

        $before_event->connection->dispatch($before_event);

        $rows = $stmt->fetchAll($mode, ...$args);

        $before_event->connection->dispatch(new AfterFetchAllEvent($before_event, $rows));

        return $rows;

    }
}
