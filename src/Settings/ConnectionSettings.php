<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Settings;

use MichaelRushton\Database\Interfaces\Settings\ConnectionSettingsInterface;

class ConnectionSettings implements ConnectionSettingsInterface
{
    public function __construct(
        protected bool $cache_prepared_statements = true
    ) {}

    public function getCachePreparedStatements(): bool
    {
        return $this->cache_prepared_statements;
    }

    public function setCachePreparedStatements(bool $cache_prepared_statements): bool
    {
        return $this->cache_prepared_statements = $cache_prepared_statements;
    }
}
