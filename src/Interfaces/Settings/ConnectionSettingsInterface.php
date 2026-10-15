<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\Settings;

interface ConnectionSettingsInterface
{
    public function getCachePreparedStatements(): bool;

    public function setCachePreparedStatements(bool $cache_prepared_statements): bool;
}
