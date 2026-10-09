<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Connections;

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Drivers\PostgreSQLDriver;
use MichaelRushton\Database\Interfaces\Connections\PostgreSQLConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLUpdateInterface;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLDelete;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLInsert;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLSelect;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLUpdate;

class PostgreSQLConnection extends Connection implements PostgreSQLConnectionInterface
{
    public function __construct(DriverInterface $driver = new PostgreSQLDriver())
    {
        parent::__construct($driver);
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
