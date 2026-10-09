<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\PostgreSQL;

use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Using;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\WhereCurrentOf;
use MichaelRushton\Database\Traits\SQL\With;

class PostgreSQLDelete extends Statement implements PostgreSQLDeleteInterface
{
    use From;
    use Join;
    use Returning;
    use Using;
    use Where;
    use WhereCurrentOf;
    use With;

    public function __construct(ConnectionInterface $connection = new PostgreSQLConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'DELETE',
            $this->getFrom(),
            $this->getUsing(),
            $this->getJoin(),
            $this->getWhere(),
            $this->where_current_of,
            $this->getReturning(),
        ];

    }
}
