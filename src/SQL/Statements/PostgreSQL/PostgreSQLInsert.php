<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\PostgreSQL;

use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\OnConflict;
use MichaelRushton\Database\Traits\SQL\Overriding;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Select;
use MichaelRushton\Database\Traits\SQL\Values;
use MichaelRushton\Database\Traits\SQL\With;

class PostgreSQLInsert extends Statement implements PostgreSQLInsertInterface
{
    use Columns;
    use Into;
    use OnConflict;
    use Overriding;
    use Returning;
    use Select;
    use Values;
    use With;

    public function __construct(ConnectionInterface $connection = new PostgreSQLConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'INSERT',
            $this->into,
            $this->getColumns(),
            $this->overriding,
            implode(' ', array_filter([
                $this->getValues(),
                $this->getSelect(),
            ], '\strlen')) ?: 'DEFAULT VALUES',
            $this->getOnConflict(),
            $this->getReturning(),
        ];

    }
}
