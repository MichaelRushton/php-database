<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDOStatement;

readonly class BeforeFetchColumnEvent extends Event
{
    public function __construct(
        public ConnectionInterface $connection,
        public PDOStatement|false $statement,
        public string $query,
        public array|string|int|float|bool|null $params,
        public int $column
    ) {
        parent::__construct();
    }
}
