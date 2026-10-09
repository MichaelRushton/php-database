<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MySQL;

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLUpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Ignore;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\LowPriority;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Table;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\With;

class MySQLUpdate extends Statement implements MySQLUpdateInterface
{
    use Ignore;
    use Join;
    use Limit;
    use LowPriority;
    use OrderBy;
    use Set;
    use Table;
    use Where;
    use With;

    public function __construct(ConnectionInterface $connection = new MySQLConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'UPDATE',
            $this->low_priority,
            $this->ignore,
            $this->getTable(),
            $this->getJoin(),
            $this->getSet(),
            $this->getWhere(),
            $this->getOrderBy(),
            $this->getLimit(),
        ];

    }
}
