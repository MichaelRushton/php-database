<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\Connection;

use MichaelRushton\Database\Events\AfterExecuteEvent;
use MichaelRushton\Database\Events\BeforeExecuteEvent;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDOStatement;

class Execute
{
    public function handle(
        ConnectionInterface $connection,
        PDOStatement $stmt,
        string $query,
        array|string|int|float|bool|null $params = null
    ): PDOStatement|false {

        $before_event = new BeforeExecuteEvent($connection, $stmt, $query, $params);

        $connection->dispatch($before_event);

        $success = $stmt->execute();

        $connection->dispatch(new AfterExecuteEvent($before_event, $success));

        return $success ? $stmt : false;

    }
}
