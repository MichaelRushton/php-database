<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Connections;

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Drivers\SQLServerDriver;
use MichaelRushton\Database\Interfaces\Connections\SQLServerConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerUpdateInterface;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerDelete;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerInsert;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerSelect;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerUpdate;

class SQLServerConnection extends Connection implements SQLServerConnectionInterface
{
    public function __construct(DriverInterface $driver = new SQLServerDriver())
    {
        parent::__construct($driver);
    }

    public function delete(): SQLServerDeleteInterface
    {
        return new SQLServerDelete($this);
    }

    public function insert(): SQLServerInsertInterface
    {
        return new SQLServerInsert($this);
    }

    public function select(): SQLServerSelectInterface
    {
        return new SQLServerSelect($this);
    }

    public function update(): SQLServerUpdateInterface
    {
        return new SQLServerUpdate($this);
    }
}
