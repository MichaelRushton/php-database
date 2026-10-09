<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MariaDB;

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBReplaceInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Delayed;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\LowPriority;
use MichaelRushton\Database\Traits\SQL\Returning;
use MichaelRushton\Database\Traits\SQL\Select;
use MichaelRushton\Database\Traits\SQL\Set;
use MichaelRushton\Database\Traits\SQL\Values;

class MariaDBReplace extends Statement implements MariaDBReplaceInterface
{
    use Columns;
    use Delayed;
    use Into;
    use LowPriority;
    use Returning;
    use Select;
    use Set;
    use Values;

    public function __construct(ConnectionInterface $connection = new MariaDBConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            'REPLACE',
            $this->low_priority,
            $this->delayed,
            $this->into,
            $this->getColumns(),
            implode(' ', array_filter([
                $this->getValues(),
                $this->getSet(),
                $this->getSelect(),
            ], '\strlen')) ?: 'VALUES ()',
            $this->getReturning(),
        ];

    }
}
