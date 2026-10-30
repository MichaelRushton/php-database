<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use PDOStatement;

class BeforeBindValueEvent extends Event
{
    public function __construct(
        public protected(set) ConnectionInterface $connection,
        public protected(set) PDOStatement|false $statement,
        public protected(set) string $query,
        public protected(set) string|int $param,
        public protected(set) mixed $value
    ) {
        parent::__construct();
    }
}
