<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Connections;

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Drivers\PostgreSQLDriver;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\CacheInterface;
use MichaelRushton\Database\Interfaces\Connections\PostgreSQLConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\EventManagerInterface;
use MichaelRushton\Database\Interfaces\Settings\ConnectionSettingsInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLUpdateInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLDelete;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLInsert;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLSelect;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLUpdate;

class PostgreSQLConnection extends Connection implements PostgreSQLConnectionInterface
{
    public function __construct(
        DriverInterface $driver = new PostgreSQLDriver(),
        ConnectionSettingsInterface $settings = new ConnectionSettings(),
        EventManagerInterface $event_manager = new EventManager(),
        CacheInterface $cache = new Cache()
    ) {

        parent::__construct(
            driver: $driver,
            settings: $settings,
            event_manager: $event_manager,
            cache: $cache
        );

    }

    public function delete(): PostgreSQLDeleteInterface
    {
        return new PostgreSQLDelete($this);
    }

    public function insert(): PostgreSQLInsertInterface
    {
        return new PostgreSQLInsert($this);
    }

    public function select(): PostgreSQLSelectInterface
    {
        return new PostgreSQLSelect($this);
    }

    public function update(): PostgreSQLUpdateInterface
    {
        return new PostgreSQLUpdate($this);
    }
}
