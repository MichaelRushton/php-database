<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Actions\SQL\Statement;

use MichaelRushton\Database\Events\AfterPrepareEvent;
use MichaelRushton\Database\Events\BeforePrepareEvent;
use MichaelRushton\Database\Interfaces\SQL\StatementInterface;

class Prepare
{
    public function handle(
        StatementInterface $statement,
        string $query,
        array $options = []
    ): mixed {

        $connection = $statement->connection();

        $connection->connect();

        $before_event = new BeforePrepareEvent($connection, $query, $options);

        $statement->eventManager()->dispatch($before_event);

        $stmt = $connection->uncached($query, $options);

        $statement->eventManager()->dispatch(new AfterPrepareEvent($before_event, $stmt));

        return $stmt;

    }
}
