<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Connections;

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Configuration;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Drivers\MariaDBDriver;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\CacheInterface;
use MichaelRushton\Database\Interfaces\ConfigurationInterface;
use MichaelRushton\Database\Interfaces\Connections\MariaDBConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\EventManagerInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBUpdateInterface;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBDelete;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBInsert;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBReplace;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBUpdate;

class MariaDBConnection extends Connection implements MariaDBConnectionInterface
{
    public function __construct(
        DriverInterface $driver = new MariaDBDriver(),
        ConfigurationInterface $configuration = new Configuration(),
        EventManagerInterface $event_manager = new EventManager(),
        CacheInterface $cache = new Cache()
    ) {

        parent::__construct(
            driver: $driver,
            configuration: $configuration,
            event_manager: $event_manager,
            cache: $cache
        );

    }

    public function delete(): MariaDBDeleteInterface
    {
        return new MariaDBDelete($this);
    }

    public function insert(): MariaDBInsertInterface
    {
        return new MariaDBInsert($this);
    }

    public function replace(): MariaDBReplaceInterface
    {
        return new MariaDBReplace($this);
    }

    public function select(): MariaDBSelectInterface
    {
        return new MariaDBSelect($this);
    }

    public function update(): MariaDBUpdateInterface
    {
        return new MariaDBUpdate($this);
    }
}
