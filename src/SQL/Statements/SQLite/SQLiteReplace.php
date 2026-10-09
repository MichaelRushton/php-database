<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLite;

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteReplaceInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Select;
use MichaelRushton\Database\Traits\SQL\Values;
use MichaelRushton\Database\Traits\SQL\With;

class SQLiteReplace extends Statement implements SQLiteReplaceInterface
{
    use Columns;
    use Into;
    use Returning;
    use Select;
    use Values;
    use With;

    public function __construct(ConnectionInterface $connection = new SQLiteConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'REPLACE',
            $this->into,
            $this->getColumns(),
            implode(' ', array_filter([
                $this->getValues(),
                $this->getSelect(),
            ], '\strlen')) ?: 'DEFAULT VALUES',
            $this->getReturning(),
        ];

    }
}
