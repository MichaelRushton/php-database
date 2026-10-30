<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDOStatement;

class BeforeFetchAllEvent extends Event
{
    public function __construct(
        public protected(set) ConnectionInterface $connection,
        public protected(set) PDOStatement|false $statement,
        public protected(set) string $query,
        public protected(set) array|string|int|float|bool|null $params,
        public protected(set) int $mode,
        public protected(set) array $args
    ) {
        parent::__construct();
    }
}
