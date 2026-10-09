<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLServer;

use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Output;
use MichaelRushton\Database\Traits\SQL\Table;
use MichaelRushton\Database\Traits\SQL\Top;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\WhereCurrentOf;
use MichaelRushton\Database\Traits\SQL\With;

class SQLServerDelete extends Statement implements SQLServerDeleteInterface
{
    use From;
    use Join;
    use Output;
    use Table;
    use Top;
    use Where;
    use WhereCurrentOf;
    use With;

    public function __construct(ConnectionInterface $connection = new SQLServerConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'DELETE',
            $this->getTop(),
            $this->getTable(),
            $this->getOutput(),
            $this->getFrom(),
            $this->getJoin(),
            $this->getWhere(),
            $this->where_current_of,
        ];

    }
}
