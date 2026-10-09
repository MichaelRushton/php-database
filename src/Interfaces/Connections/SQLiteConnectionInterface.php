<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\Connections;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteUpdateInterface;

interface SQLiteConnectionInterface extends ConnectionInterface
{
    public function delete(): SQLiteDeleteInterface;

    public function insert(): SQLiteInsertInterface;

    public function replace(): SQLiteReplaceInterface;

    public function select(): SQLiteSelectInterface;

    public function update(): SQLiteUpdateInterface;
}
