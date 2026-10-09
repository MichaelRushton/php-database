<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\PostgreSQL;

use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLSelectInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Distinct;
use MichaelRushton\Database\Traits\SQL\ForKeyShare;
use MichaelRushton\Database\Traits\SQL\ForNoKeyUpdate;
use MichaelRushton\Database\Traits\SQL\ForShare;
use MichaelRushton\Database\Traits\SQL\ForUpdate;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\GroupBy;
use MichaelRushton\Database\Traits\SQL\Having;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\OffsetFetch;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\SelectColumns;
use MichaelRushton\Database\Traits\SQL\SetOperation;
use MichaelRushton\Database\Traits\SQL\ToSubquery;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\Window;
use MichaelRushton\Database\Traits\SQL\With;

class PostgreSQLSelect extends Statement implements PostgreSQLSelectInterface
{
    use Distinct;
    use ForKeyShare;
    use ForNoKeyUpdate;
    use ForShare;
    use ForUpdate;
    use From;
    use GroupBy;
    use Having;
    use Join;
    use Limit;
    use OffsetFetch;
    use OrderBy;
    use SelectColumns;
    use SetOperation;
    use ToSubquery;
    use Where;
    use Window;
    use With;

    public function __construct(ConnectionInterface $connection = new PostgreSQLConnection())
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
            $this->getLimit() ?: $this->getOffsetFetch(),
            $this->getForUpdate(),
            $this->getForNoKeyUpdate(),
            $this->getForShare(),
            $this->getForKeyShare(),
        ];

    }
}
