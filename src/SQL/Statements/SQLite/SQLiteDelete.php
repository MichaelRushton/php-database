<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLite;

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\With;

class SQLiteDelete extends Statement implements SQLiteDeleteInterface
{
    use From;
    use Limit;
    use OrderBy;
    use Returning;
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
            'DELETE',
            $this->getFrom(),
            $this->getWhere(),
            $this->getReturning(),
            $this->getOrderBy(),
            $this->getLimit(),
        ];

    }
}
