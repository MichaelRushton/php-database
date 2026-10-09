<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\SQLServer;

use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerSelectInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Distinct;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\GroupBy;
use MichaelRushton\Database\Traits\SQL\Having;
use MichaelRushton\Database\Traits\SQL\Into;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\OffsetFetch;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\SelectColumns;
use MichaelRushton\Database\Traits\SQL\SetOperation;
use MichaelRushton\Database\Traits\SQL\Top;
use MichaelRushton\Database\Traits\SQL\ToSubquery;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\Window;
use MichaelRushton\Database\Traits\SQL\With;

class SQLServerSelect extends Statement implements SQLServerSelectInterface
{
    use Distinct;
    use From;
    use GroupBy;
    use Having;
    use Into;
    use Join;
    use OffsetFetch;
    use OrderBy;
    use SelectColumns;
    use SetOperation;
    use Top;
    use ToSubquery;
    use Where;
    use Window;
    use With;

    public function __construct(ConnectionInterface $connection = new SQLServerConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'SELECT',
            $this->distinct,
            $this->getTop(),
            $this->getColumns(),
            $this->into,
            $this->getFrom(),
            $this->getJoin(),
            $this->getWhere(),
            $this->getGroupBy(),
            $this->getHaving(),
            $this->getWindow(),
            $this->getSetOperation(),
            $this->getOrderBy(),
            $this->getOffsetFetch(),
        ];

    }
}
