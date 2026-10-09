<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Connections;

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Drivers\SQLiteDriver;
use MichaelRushton\Database\Interfaces\Connections\SQLiteConnectionInterface;
use MichaelRushton\Database\Interfaces\DriverInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteUpdateInterface;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteDelete;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteReplace;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteUpdate;

class SQLiteConnection extends Connection implements SQLiteConnectionInterface
{
    public function __construct(DriverInterface $driver = new SQLiteDriver())
    {
        parent::__construct($driver);
    }

    public function delete(): SQLiteDeleteInterface
    {
        return new SQLiteDelete($this);
    }

    public function insert(): SQLiteInsertInterface
    {
        return new SQLiteInsert($this);
    }

    public function replace(): SQLiteReplaceInterface
    {
        return new SQLiteReplace($this);
    }

    public function select(): SQLiteSelectInterface
    {
        return new SQLiteSelect($this);
    }

    public function update(): SQLiteUpdateInterface
    {
        return new SQLiteUpdate($this);
    }
}
