<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\Connection;

use MichaelRushton\Database\Events\AfterFetchObjectEvent;
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDOStatement;

class FetchObject
{
    public function handle(
        ConnectionInterface $connection,
        PDOStatement $stmt,
        string $query,
        array|string|int|float|bool|null $params,
        ?string $class = 'stdClass',
        array $constructorArgs = []
    ): object|false {

        $before_event = new BeforeFetchObjectEvent($connection, $stmt, $query, $params, $class, $constructorArgs);

        $connection->dispatch($before_event);

        $object = $stmt->fetchObject($class, $constructorArgs);

        $connection->dispatch(new AfterFetchObjectEvent($before_event, $object));

        return $object;

    }
}
