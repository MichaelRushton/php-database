<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Interfaces\ConnectionInterface;

class BeforeQueryEvent extends Event
{
    public function __construct(
        public protected(set) ConnectionInterface $connection,
        public protected(set) string $query,
        public protected(set) ?int $fetchMode,
        public protected(set) array $fetchModeArgs
    ) {
        parent::__construct();
    }
}
