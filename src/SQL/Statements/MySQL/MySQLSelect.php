<?php

declare(strict_types=1);

namespace MichaelRushton\Database\SQL\Statements\MySQL;

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLSelectInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\Traits\SQL\Distinct;
use MichaelRushton\Database\Traits\SQL\ForShare;
use MichaelRushton\Database\Traits\SQL\ForUpdate;
use MichaelRushton\Database\Traits\SQL\From;
use MichaelRushton\Database\Traits\SQL\GroupBy;
use MichaelRushton\Database\Traits\SQL\Having;
use MichaelRushton\Database\Traits\SQL\HighPriority;
use MichaelRushton\Database\Traits\SQL\IntoDumpfile;
use MichaelRushton\Database\Traits\SQL\IntoOutfile;
use MichaelRushton\Database\Traits\SQL\IntoVar;
use MichaelRushton\Database\Traits\SQL\Join;
use MichaelRushton\Database\Traits\SQL\Limit;
use MichaelRushton\Database\Traits\SQL\LockInShareMode;
use MichaelRushton\Database\Traits\SQL\OrderBy;
use MichaelRushton\Database\Traits\SQL\SelectColumns;
use MichaelRushton\Database\Traits\SQL\SetOperation;
use MichaelRushton\Database\Traits\SQL\SQLBigResult;
use MichaelRushton\Database\Traits\SQL\SQLBufferResult;
use MichaelRushton\Database\Traits\SQL\SQLCalcFoundRows;
use MichaelRushton\Database\Traits\SQL\SQLSmallResult;
use MichaelRushton\Database\Traits\SQL\StraightJoin;
use MichaelRushton\Database\Traits\SQL\ToSubquery;
use MichaelRushton\Database\Traits\SQL\Where;
use MichaelRushton\Database\Traits\SQL\Window;
use MichaelRushton\Database\Traits\SQL\With;

class MySQLSelect extends Statement implements MySQLSelectInterface
{
    use Distinct;
    use ForShare;
    use ForUpdate;
    use From;
    use GroupBy;
    use Having;
    use HighPriority;
    use IntoDumpfile;
    use IntoOutfile;
    use IntoVar;
    use Join;
    use Limit;
    use LockInShareMode;
    use OrderBy;
    use SelectColumns;
    use SetOperation;
    use SQLBigResult;
    use SQLBufferResult;
    use SQLCalcFoundRows;
    use SQLSmallResult;
    use StraightJoin;
    use ToSubquery;
    use Where;
    use Window;
    use With;

    public function __construct(ConnectionInterface $connection = new MySQLConnection())
    {
        parent::__construct($connection);
    }

    public function toArray(): array
    {

        return [
            $this->getWith(),
            'SELECT',
            $this->distinct,
            $this->high_priority,
            $this->straight_join,
            $this->sql_small_result,
            $this->sql_big_result,
            $this->sql_buffer_result,
            $this->sql_calc_found_rows,
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
            $this->getIntoOutfile(),
            $this->into_dumpfile,
            $this->getIntoVar(),
            $this->getForUpdate(),
            $this->getForShare(),
            $this->lock_in_share_mode,
        ];

    }
}
