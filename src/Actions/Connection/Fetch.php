<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\Connection;

use MichaelRushton\Database\Events\AfterFetchEvent;
use MichaelRushton\Database\Events\BeforeFetchEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDO;
use PDOStatement;

class Fetch
{
    public function handle(
        ConnectionInterface $connection,
        PDOStatement $stmt,
        string $query,
        array|string|int|float|bool|null $params,
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed {

        $before_event = new BeforeFetchEvent($connection, $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset);

        $connection->dispatch($before_event);

        $row = $stmt->fetch($mode, $cursorOrientation, $cursorOffset);

        $connection->dispatch(new AfterFetchEvent($before_event, $row));

        return $row;

    }
}
