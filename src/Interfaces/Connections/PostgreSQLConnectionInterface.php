<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\Connections;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLUpdateInterface;

interface PostgreSQLConnectionInterface extends ConnectionInterface
{
    public function delete(): PostgreSQLDeleteInterface;

    public function insert(): PostgreSQLInsertInterface;

    public function select(): PostgreSQLSelectInterface;

    public function update(): PostgreSQLUpdateInterface;
}
