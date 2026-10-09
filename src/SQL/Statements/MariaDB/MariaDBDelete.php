<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MariaDB;

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\Ignore;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\LowPriority;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\Quick;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Table;
use MichaelRushton\Database\Traits\SQL\Using;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\With;

class MariaDBDelete extends Statement implements MariaDBDeleteInterface
{
    use From;
    use Ignore;
    use Join;
    use Limit;
    use LowPriority;
    use OrderBy;
    use Quick;
    use Returning;
    use Table;
    use Using;
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
            'DELETE',
            $this->low_priority,
            $this->quick,
            $this->ignore,
            $this->getTable(),
            $this->getFrom(),
            $this->getUsing(),
            $this->getJoin(),
            $this->getWhere(),
            $this->getOrderBy(),
            $this->getLimit(),
            $this->getReturning(),
        ];

    }
}
