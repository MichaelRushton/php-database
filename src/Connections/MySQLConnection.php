<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Connections;

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Drivers\MySQLDriver;
use MichaelRushton\Database\Interfaces\Connections\MySQLConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLUpdateInterface;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLDelete;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLInsert;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLReplace;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLSelect;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLUpdate;

class MySQLConnection extends Connection implements MySQLConnectionInterface
{
    public function __construct(DriverInterface $driver = new MySQLDriver())
    {
        parent::__construct($driver);
    }

    public function delete(): MySQLDeleteInterface
    {
        return new MySQLDelete($this);
    }

    public function insert(): MySQLInsertInterface
    {
        return new MySQLInsert($this);
    }

    public function replace(): MySQLReplaceInterface
    {
        return new MySQLReplace($this);
    }

    public function select(): MySQLSelectInterface
    {
        return new MySQLSelect($this);
    }

    public function update(): MySQLUpdateInterface
    {
        return new MySQLUpdate($this);
    }
}
