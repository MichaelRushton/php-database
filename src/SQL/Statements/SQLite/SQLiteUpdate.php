<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLite;

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteUpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\OrOnConflict;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Table;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\With;

class SQLiteUpdate extends Statement implements SQLiteUpdateInterface
{
    use From;
    use Join;
    use Limit;
    use OrderBy;
    use OrOnConflict;
    use Returning;
    use Set;
    use Table;
    use Where;
    use With;

    public function __construct(ConnectionInterface $connection = new SQLiteConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'UPDATE',
            $this->or,
            $this->getTable(),
            $this->getSet(),
            $this->getFrom(),
            $this->getJoin(),
            $this->getWhere(),
            $this->getReturning(),
            $this->getOrderBy(),
            $this->getLimit(),
        ];

    }
}
