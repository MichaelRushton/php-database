<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\Connections;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLUpdateInterface;

interface MySQLConnectionInterface extends ConnectionInterface
{
    public function delete(): MySQLDeleteInterface;

    public function insert(): MySQLInsertInterface;

    public function replace(): MySQLReplaceInterface;

    public function select(): MySQLSelectInterface;

    public function update(): MySQLUpdateInterface;
}
