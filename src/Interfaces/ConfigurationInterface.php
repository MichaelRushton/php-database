<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces;

interface ConfigurationInterface
{
    public bool $cache_prepared_statements { get; set; }
}
