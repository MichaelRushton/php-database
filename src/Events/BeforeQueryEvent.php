<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Events;

use MichaelRushton\Database\Event;
use MichaelRushton\Database\Interfaces\ConnectionInterface;

readonly class BeforeQueryEvent extends Event
{
    public function __construct(
        public ConnectionInterface $connection,
        public string $query,
        public ?int $fetchMode,
        public array $fetchModeArgs
    ) {
        parent::__construct();
    }
}
