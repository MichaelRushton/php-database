<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\Connection;

use MichaelRushton\Database\Events\AfterFetchColumnEvent;
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDOStatement;

class FetchColumn
{
    public function handle(
        ConnectionInterface $connection,
        PDOStatement $stmt,
        string $query,
        array|string|int|float|bool|null $params = null,
        int $column = 0
    ): mixed {

        $before_event = new BeforeFetchColumnEvent($connection, $stmt, $query, $params, $column);

        $connection->eventManager()->dispatch($before_event);

        $value = $stmt->fetchColumn($column);

        $connection->eventManager()->dispatch(new AfterFetchColumnEvent($before_event, $value));

        return $value;

    }
}
