<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLite;

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteSelectInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Distinct;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\GroupBy;
use MichaelRushton\Database\Traits\SQL\Having;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\SelectColumns;
use MichaelRushton\Database\Traits\SQL\SetOperation;
use MichaelRushton\Database\Traits\SQL\ToSubquery;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\Window;
use MichaelRushton\Database\Traits\SQL\With;

class SQLiteSelect extends Statement implements SQLiteSelectInterface
{
    use Distinct;
    use From;
    use GroupBy;
    use Having;
    use Join;
    use Limit;
    use OrderBy;
    use SelectColumns;
    use SetOperation;
    use ToSubquery;
    use Where;
    use Window;
    use With;

    public function __construct(ConnectionInterface $connection = new SQLiteConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'SELECT',
            $this->distinct,
            $this->getColumns(),
            $this->getFrom(),
            $this->getJoin(),
            $this->getWhere(),
            $this->getGroupBy(),
            $this->getHaving(),
            $this->getWindow(),
            $this->getSetOperation(),
            $this->getOrderBy(),
            $this->getLimit(),
        ];

    }
}
