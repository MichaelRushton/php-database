<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\Connections;

use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerDeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerInsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerSelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerUpdateInterface;

interface SQLServerConnectionInterface extends ConnectionInterface
{
    public function delete(): SQLServerDeleteInterface;

    public function insert(): SQLServerInsertInterface;

    public function select(): SQLServerSelectInterface;

    public function update(): SQLServerUpdateInterface;
}
