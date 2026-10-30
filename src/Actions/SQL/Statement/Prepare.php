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

        $statement->connection->connect();

        $before_event = new BeforePrepareEvent($statement->connection, $query, $options);

        $statement->event_manager->dispatch($before_event);

        $stmt = $statement->connection->uncached($query, $options);

        $statement->event_manager->dispatch(new AfterPrepareEvent($before_event, $stmt));

        return $stmt;

    }
}
