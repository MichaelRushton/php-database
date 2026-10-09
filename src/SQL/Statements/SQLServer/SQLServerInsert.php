<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLServer;

use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Columns;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\Output;
use MichaelRushton\Database\Traits\SQL\Select;
use MichaelRushton\Database\Traits\SQL\Top;
use MichaelRushton\Database\Traits\SQL\Values;
use MichaelRushton\Database\Traits\SQL\With;

class SQLServerInsert extends Statement implements SQLServerInsertInterface
{
    use Columns;
    use Into;
    use Output;
    use Select;
    use Top;
    use Values;
    use With;

    public function __construct(ConnectionInterface $connection = new SQLServerConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'INSERT',
            $this->getTop(),
            $this->into,
            $this->getColumns(),
            $this->getOutput(),
            implode(' ', array_filter([
                $this->getValues(),
                $this->getSelect(),
            ], '\strlen')) ?: 'DEFAULT VALUES',
        ];

    }
}
