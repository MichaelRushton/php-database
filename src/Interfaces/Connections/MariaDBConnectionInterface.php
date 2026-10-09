<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\Connections;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBUpdateInterface;

interface MariaDBConnectionInterface extends ConnectionInterface
{
    public function delete(): MariaDBDeleteInterface;

    public function insert(): MariaDBInsertInterface;

    public function replace(): MariaDBReplaceInterface;

    public function select(): MariaDBSelectInterface;

    public function update(): MariaDBUpdateInterface;
}
