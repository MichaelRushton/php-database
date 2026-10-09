<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\SQL\Statement;

use MichaelRushton\Database\Actions\Connection\Fetch as ConnectionFetch;
use MichaelRushton\Database\Events\AfterFetchEvent;
use MichaelRushton\Database\Events\BeforeFetchEvent;
use MichaelRushton\Database\Interfaces\SQL\StatementInterface;
use PDO;
use PDOStatement;

class Fetch
{
    public function handle(
        StatementInterface $statement,
        PDOStatement $stmt,
        string $query,
        array|string|int|float|bool|null $params,
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed {

        $before_event = new BeforeFetchEvent($statement->connection(), $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset);

        $statement->dispatch($before_event);

        $row = new ConnectionFetch()->handle($before_event->connection, $stmt, $query, $params, $mode, $cursorOrientation, $cursorOffset);

        $statement->dispatch(new AfterFetchEvent($before_event, $row));

        return $row;

    }
}
