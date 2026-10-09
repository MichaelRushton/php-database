<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MySQL;

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLReplaceInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\LowPriority;
use MichaelRushton\Database\Traits\SQL\Select;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Values;

class MySQLReplace extends Statement implements MySQLReplaceInterface
{
    use Columns;
    use Into;
    use LowPriority;
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
            'REPLACE',
            $this->low_priority,
            $this->into,
            $this->getColumns(),
            implode(' ', array_filter([
                $this->getValues(),
                $this->getSet(),
                $this->getSelect(),
            ], '\strlen')) ?: 'VALUES ()',
        ];

    }
}
