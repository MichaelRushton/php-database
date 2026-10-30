<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use MichaelRushton\Database\Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function __construct(
        public bool $cache_prepared_statements = true
    ) {}
}
