<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MySQL;

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\HighPriority;
use MichaelRushton\Database\Traits\SQL\Ignore;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\LowPriority;
use MichaelRushton\Database\Traits\SQL\OnDuplicateKeyUpdate;
use MichaelRushton\Database\Traits\SQL\RowAlias;
use MichaelRushton\Database\Traits\SQL\Select;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Values;

class MySQLInsert extends Statement implements MySQLInsertInterface
{
    use Columns;
    use HighPriority;
    use Ignore;
    use Into;
    use LowPriority;
    use OnDuplicateKeyUpdate;
    use RowAlias;
    use Select;
    use Set;
    use Values;

    public function __construct(ConnectionInterface $connection = new MySQLConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            'INSERT',
            $this->low_priority,
            $this->high_priority,
            $this->ignore,
            $this->into,
            $this->getColumns(),
            implode(' ', array_filter([
                $this->getValues(),
                $this->getSet(),
                $this->getSelect(),
            ], '\strlen')) ?: 'VALUES ()',
            $this->row_alias,
            $this->getOnDuplicateKeyUpdate(),
        ];

    }
}
