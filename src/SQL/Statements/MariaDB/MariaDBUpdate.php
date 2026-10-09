<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MariaDB;

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBUpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Ignore;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\LowPriority;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Table;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\With;

class MariaDBUpdate extends Statement implements MariaDBUpdateInterface
{
    use Ignore;
    use Join;
    use Limit;
    use LowPriority;
    use OrderBy;
    use Returning;
    use Set;
    use Table;
    use Where;
    use With;

    public function __construct(ConnectionInterface $connection = new MariaDBConnection())
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
            $this->getReturning(),
        ];

    }
}
