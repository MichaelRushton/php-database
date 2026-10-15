# PHP Database

[Go back](../../README.md)

## `SELECT`

```php
$stmt = $connection->select();
// SELECT * ...
```

#### `distinct`

```php
$stmt->distinct();
// SELECT DISTINCT ...
```

#### `top`

`SQLServer` only.

```php
$stmt->top(10);
// SELECT TOP (10) ...
```

```php
$stmt->top(10)->percent();
// SELECT TOP (10) PERCENT ...
```

```php
$stmt->top(10)->withTies();
// SELECT TOP (10) WITH TIES ...
```

#### `columns`

```php
$stmt->columns('c1');
// SELECT c1 ...
```

```php
$stmt->columns('c1', 'c2');
// SELECT c1, c2 ...
```

```php
$stmt->columns(['a' => 'c1', 'b' => 'c2']);
// SELECT c1 a, c2 b ...
```

See [Subquery](../components/subquery.md).

```php
$stmt->columns(
    $connection->select()
    ->columns('COUNT(*)')
    ->from('t1')
    ->toSubquery()
    ->as('count')
);
// SELECT (SELECT COUNT(*) FROM t1) count
```

```php
use MichaelRushton\Database\SQL;

$stmt->columns(SQL::bind($param));
// SELECT ? ...
```

#### `from`

```php
$stmt->from('t1');
// SELECT ... FROM t1
```

```php
$stmt->from('t1', 't2');
// SELECT ... FROM t1, t2
```

```php
$stmt->from(['a' => 't1', 'b' => 't2']);
// SELECT ... FROM t1 a, t2 b
```

See [Subquery](../components/subquery.md).

```php
$stmt->from(
    $connection->select()
    ->columns('c1')
    ->from('t1')
);
// SELECT ... FROM (SELECT c1 FROM t1)
```

See [Table](../components/table.md).

```php
use MichaelRushton\Database\SQL\Components\Table;

$stmt->from(new Table('t1'));
// SELECT ... FROM t1
```

#### `join`

```php
$stmt->join('t2');
// SELECT ... JOIN t2
```

```php
$stmt->join(['t2', 't3']);
// SELECT ... JOIN t2 JOIN t3
```

```php
$stmt->join(['b' => 't2', 'c' => 't3']);
// SELECT ... JOIN t2 b JOIN t3 c
```

```php
$stmt->join('t2', 'c1');
// SELECT ... JOIN t2 USING (c1)
```

```php
$stmt->join('t2', ['c1', 'c2']);
// SELECT ... JOIN t2 USING (c1, c2)
```

```php
$stmt->join('t2', 'c1', 'c2');
// SELECT ... JOIN t2 ON c1 = c2
```

```php
$stmt->join('t2', 'c1', '!=', 'c2');
// SELECT ... JOIN t2 ON c1 != c2
```

```php
$stmt->join('t2', [
    'c1' => 'c2',
    'c3' => 'c4',
]);
// SELECT ... JOIN t2 ON (c1 = c2 AND c3 = c4)
```

```php
$stmt->join('t2', 'c1', SQL::bind($param));
// SELECT ... JOIN t2 ON c1 = ?
```

```php
use MichaelRushton\Database\SQL\Components\On;

$stmt->join('t2', function (On $on)
{
    $on->on('c1', 'c2')
    ->on('c3', 'c4');
});
// SELECT ... JOIN t2 ON (c1 = c2 AND c3 = c4)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->on('c1', 'c2')
    ->orOn('c3', 'c4');
});
// SELECT ... JOIN t2 ON (c1 = c2 OR c3 = c4)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onNot('c1', 'c2')
    ->orOnNot('c3', 'c4');
});
// SELECT ... JOIN t2 ON (NOT c1 = c2 OR NOT c3 = c4)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onIn('c1', ['c2', 'c3'])
    ->onIn('c4', ['c5', 'c6']);
});
// SELECT ... JOIN t2 ON (c1 IN (c2, c3) AND c4 IN (c5, c6))
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onIn('c1', ['c2', 'c3'])
    ->orOnIn('c4', ['c5', 'c6']);
});
// SELECT ... JOIN t2 ON (c1 IN (c2, c3) OR c4 IN (c5, c6))
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onNotIn('c1', ['c2', 'c3'])
    ->orOnNotIn('c4', ['c5', 'c6']);
});
// SELECT ... JOIN t2 ON (NOT c1 IN (c2, c3) OR NOT c4 IN (c5, c6))
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onBetween('c1', 'c2', 'c3')
    ->onBetween('c4', 'c5', 'c6');
});
// SELECT ... JOIN t2 ON (c1 BETWEEN c2 AND c3 AND c4 BETWEEN c5 AND c6)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onBetween('c1', 'c2', 'c3')
    ->orOnBetween('c4', 'c5', 'c6');
});
// SELECT ... JOIN t2 ON (c1 BETWEEN c2 AND c3 OR c4 BETWEEN c5 AND c6)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onNotBetween('c1', 'c2', 'c3')
    ->orOnNotBetween('c4', 'c5', 'c6');
});
// SELECT ... JOIN t2 ON (NOT c1 BETWEEN c2 AND c3 OR NOT c4 BETWEEN c5 AND c6)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onNull('c1')
    ->onNull('c2');
});
// SELECT ... JOIN t2 ON (c1 IS NULL AND c2 IS NULL)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onNull('c1')
    ->orOnNull('c2');
});
// SELECT ... JOIN t2 ON (c1 IS NULL OR c2 IS NULL)
```

```php
$stmt->join('t2', function (On $on)
{
    $on->onNotNull('c1')
    ->orOnNotNull('c2');
});
// SELECT ... JOIN t2 ON (NOT c1 IS NULL OR NOT c2 IS NULL)
```

See [Subquery](../components/subquery.md).

```php
$stmt->join(
    $connection->select()
    ->columns('c1')
    ->from('t1')
    ->toSubquery()
    ->as('t2')
);
// SELECT ... JOIN (SELECT c1 FROM t1) t2
```

See [Table](../components/table.md).

```php
$stmt->join(new Table('t2'));
// SELECT ... JOIN t2
```

#### `leftJoin`

```php
$stmt->leftJoin('t2', ...$on);
// SELECT ... LEFT JOIN t2 ...
```

#### `rightJoin`

```php
$stmt->rightJoin('t2', ...$on);
// SELECT ... RIGHT JOIN t2 ...
```

#### `fullJoin`

```php
$stmt->fullJoin('t2', ...$on);
// SELECT ... FULL JOIN t2 ...
```

#### `straightJoin`

`MariaDB` and `MySQL` only.

```php
$stmt->straightJoin('t2', ...$on);
// SELECT ... STRAIGHT_JOIN t2 ...
```

#### `crossJoin`

```php
$stmt->crossJoin('t2');
// SELECT ... CROSS JOIN t2
```

#### `naturalJoin`

```php
$stmt->naturalJoin('t2');
// SELECT ... NATURAL JOIN t2
```

#### `naturalLeftJoin`

```php
$stmt->naturalLeftJoin('t2');
// SELECT ... NATURAL LEFT JOIN t2
```

#### `naturalRightJoin`

```php
$stmt->naturalRightJoin('t2');
// SELECT ... NATURAL RIGHT JOIN t2
```

#### `naturalFullJoin`

```php
$stmt->naturalFullJoin('t2');
// SELECT ... NATURAL FULL JOIN t2
```

#### `where`

```php
$stmt->where('c1', $param);
// SELECT ... WHERE c1 = ?
```

```php
$stmt->where('c1', '!=', $param);
// SELECT ... WHERE c1 != ?
```

```php
$stmt->where([
    'c1' => $param1,
    'c2' => $param2,
]);
// SELECT ... WHERE (c1 = ? AND c2 = ?)
```

```php
$stmt->where('c1', new Raw('c2'));
// SELECT ... WHERE c1 = c2
```

```php
use MichaelRushtwhere\Database\SQL\Components\Where;

$stmt->where(function (Where $where)
{
    $where->where('c1', $param1)
    ->where('c2', $param2);
});
// SELECT ... WHERE (c1 = ? AND c2 = ?)
```

```php
$stmt->where(function (Where $where)
{
    $where->where('c1', $param1)
    ->orWhere('c2', $param2);
});
// SELECT ... WHERE (c1 = ? OR c2 = ?)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereNot('c1', $param1)
    ->orWhereNot('c2', $param2);
});
// SELECT ... WHERE (NOT c1 = ? OR NOT c2 = ?)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereIn('c1', [$param1, $param2])
    ->whereIn('c2', [$param3, $param4]);
});
// SELECT ... WHERE (c1 IN (?, ?) AND c2 IN (?, ?))
```

```php
$stmt->where(function (Where $where)
{
    $where->whereIn('c1', [$param1, $param2])
    ->orWhereIn('c2', [$param3, $param4]);
});
// SELECT ... WHERE (c1 IN (?, ?) OR c2 IN (?, ?))
```

```php
$stmt->where(function (Where $where)
{
    $where->whereNotIn('c1', [$param1, $param2])
    ->orWhereNotIn('c2', [$param3, $param4]);
});
// SELECT ... WHERE (NOT c1 IN (?, ?) OR NOT c2 IN (?, ?))
```

```php
$stmt->where(function (Where $where)
{
    $where->whereBetween('c1', $param1, $param2)
    ->whereBetween('c2', $param3, $param4);
});
// SELECT ... WHERE (c1 BETWEEN ? AND ? AND c2 BETWEEN ? AND ?)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereBetween('c1', $param1, $param2)
    ->orWhereBetween('c2', $param3, $param4);
});
// SELECT ... WHERE (c1 BETWEEN ? AND ? OR c2 BETWEEN ? AND ?)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereNotBetween('c1', $param1, $param2)
    ->orWhereNotBetween('c2', $param3, $param4);
});
// SELECT ... WHERE (NOT c1 BETWEEN ? AND ? OR NOT c2 BETWEEN ? AND ?)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereNull('c1')
    ->whereNull('c2');
});
// SELECT ... WHERE (c1 IS NULL AND c2 IS NULL)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereNull('c1')
    ->orWhereNull('c2');
});
// SELECT ... WHERE (c1 IS NULL OR c2 IS NULL)
```

```php
$stmt->where(function (Where $where)
{
    $where->whereNotNull('c1')
    ->orWhereNotNull('c2');
});
// SELECT ... WHERE (NOT c1 IS NULL OR NOT c2 IS NULL)
```

See [Subquery](../components/subquery.md).

```php
$stmt->where(
    $connection->select()
    ->columns('COUNT(*)')
    ->from('t1'),
    0
);
// SELECT ... WHERE (SELECT COUNT(*) FROM t1) = 0
```

#### `orWhere`

```php
$stmt->where('c1', $param1)
->orWhere('c2', $param2);
// SELECT ... WHERE c1 = ? OR c2 = ?
```

#### `whereNot`

```php
$stmt->whereNot('c1', $param);
// SELECT ... WHERE NOT c1 = ?
```

#### `orWhereNot`

```php
$stmt->where('c1', $param1)
->orWhereNot('c2', $param2);
// SELECT ... WHERE c1 = ? OR NOT c2 = ?
```

#### `whereIn`

```php
$stmt->whereIn('c1', [$param1, $param2]);
// SELECT ... WHERE c1 IN (?, ?)
```

#### `orWhereIn`

```php
$stmt->where('c1', $param1)
->orWhereIn('c2', [$param2, $param3]);
// SELECT ... WHERE c1 = ? OR c2 IN (?, ?)
```

#### `whereNotIn`

```php
$stmt->whereNotIn('c1', [$param1, $param2]);
// SELECT ... WHERE NOT c1 IN (?, ?)
```

#### `orWhereNotIn`

```php
$stmt->where('c1', $param1)
->orWhereNotIn('c2', [$param2, $param3]);
// SELECT ... WHERE c1 = ? OR NOT c2 IN (?, ?)
```

#### `whereBetween`

```php
$stmt->whereBetween('c1', $param1, $param2);
// SELECT ... WHERE c1 BETWEEN ? AND ?
```

#### `orWhereBetween`

```php
$stmt->where('c1', $param1)
->orWhereBetween('c2', $param2, $param3);
// SELECT ... WHERE c1 = ? OR c2 BETWEEN ? AND ?
```

#### `whereNotBetween`

```php
$stmt->whereNotBetween('c1', $param1, $param2);
// SELECT ... WHERE NOT c1 BETWEEN ? AND ?
```

#### `orWhereNotBetween`

```php
$stmt->where('c1', $param1)
->orWhereNotBetween('c2', $param2, $param3);
// SELECT ... WHERE c1 = ? OR NOT c2 BETWEEN ? AND ?
```

#### `whereNull`

```php
$stmt->whereNull('c1');
// SELECT ... WHERE c1 IS NULL
```

#### `orWhereNull`

```php
$stmt->where('c1', $param)
->orWhereNull('c2');
// SELECT ... WHERE c1 = ? OR c2 IS NULL
```

#### `whereNotNull`

```php
$stmt->whereNotNull('c1');
// SELECT ... WHERE NOT c1 IS NULL
```

#### `orWhereNotNull`

```php
$stmt->where('c1', $param)
->orWhereNotNull('c2');
// SELECT ... WHERE c1 = ? OR NOT c2 IS NULL
```

#### `groupBy`

```php
$stmt->groupBy('c1');
// SELECT ... GROUP BY c1
```

```php
$stmt->groupBy('c1', 'c2');
// SELECT ... GROUP BY c1, c2
```

```php
$stmt->groupBy(['c1', 'c2']);
// SELECT ... GROUP BY c1, c2
```

`MariaDB` and `MySQL` only.

```php
$stmt->groupBy('c1')->withRollup();
// SELECT ... GROUP BY c1 WITH ROLLUP
```

#### `having`

```php
$stmt->having('c1', $param);
// SELECT ... HAVING c1 = ?
```

```php
$stmt->having('c1', '!=', $param);
// SELECT ... HAVING c1 != ?
```

```php
$stmt->having([
    'c1' => $param1,
    'c2' => $param2,
]);
// SELECT ... HAVING (c1 = ? AND c2 = ?)
```

```php
$stmt->having('c1', new Raw('c2'));
// SELECT ... HAVING c1 = c2
```

```php
use MichaelRushthaving\Database\SQL\Components\Having;

$stmt->having(function (Having $having)
{
    $having->having('c1', $param1)
    ->having('c2', $param2);
});
// SELECT ... HAVING (c1 = ? AND c2 = ?)
```

```php
$stmt->having(function (Having $having)
{
    $having->having('c1', $param1)
    ->orHaving('c2', $param2);
});
// SELECT ... HAVING (c1 = ? OR c2 = ?)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingNot('c1', $param1)
    ->orHavingNot('c2', $param2);
});
// SELECT ... HAVING (NOT c1 = ? OR NOT c2 = ?)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingIn('c1', [$param1, $param2])
    ->havingIn('c2', [$param3, $param4]);
});
// SELECT ... HAVING (c1 IN (?, ?) AND c2 IN (?, ?))
```

```php
$stmt->having(function (Having $having)
{
    $having->havingIn('c1', [$param1, $param2])
    ->orHavingIn('c2', [$param3, $param4]);
});
// SELECT ... HAVING (c1 IN (?, ?) OR c2 IN (?, ?))
```

```php
$stmt->having(function (Having $having)
{
    $having->havingNotIn('c1', [$param1, $param2])
    ->orHavingNotIn('c2', [$param3, $param4]);
});
// SELECT ... HAVING (NOT c1 IN (?, ?) OR NOT c2 IN (?, ?))
```

```php
$stmt->having(function (Having $having)
{
    $having->havingBetween('c1', $param1, $param2)
    ->havingBetween('c2', $param3, $param4);
});
// SELECT ... HAVING (c1 BETWEEN ? AND ? AND c2 BETWEEN ? AND ?)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingBetween('c1', $param1, $param2)
    ->orHavingBetween('c2', $param3, $param4);
});
// SELECT ... HAVING (c1 BETWEEN ? AND ? OR c2 BETWEEN ? AND ?)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingNotBetween('c1', $param1, $param2)
    ->orHavingNotBetween('c2', $param3, $param4);
});
// SELECT ... HAVING (NOT c1 BETWEEN ? AND ? OR NOT c2 BETWEEN ? AND ?)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingNull('c1')
    ->havingNull('c2');
});
// SELECT ... HAVING (c1 IS NULL AND c2 IS NULL)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingNull('c1')
    ->orHavingNull('c2');
});
// SELECT ... HAVING (c1 IS NULL OR c2 IS NULL)
```

```php
$stmt->having(function (Having $having)
{
    $having->havingNotNull('c1')
    ->orHavingNotNull('c2');
});
// SELECT ... HAVING (NOT c1 IS NULL OR NOT c2 IS NULL)
```

See [Subquery](../components/subquery.md).

```php
$stmt->having(
    $connection->select()
    ->columns('COUNT(*)')
    ->from('t1'),
    0
);
// SELECT ... HAVING (SELECT COUNT(*) FROM t1) = 0
```

#### `orHaving`

```php
$stmt->having('c1', $param1)
->orHaving('c2', $param2);
// SELECT ... HAVING c1 = ? OR c2 = ?
```

#### `havingNot`

```php
$stmt->havingNot('c1', $param);
// SELECT ... HAVING NOT c1 = ?
```

#### `orHavingNot`

```php
$stmt->having('c1', $param1)
->orHavingNot('c2', $param2);
// SELECT ... HAVING c1 = ? OR NOT c2 = ?
```

#### `havingIn`

```php
$stmt->havingIn('c1', [$param1, $param2]);
// SELECT ... HAVING c1 IN (?, ?)
```

#### `orHavingIn`

```php
$stmt->having('c1', $param1)
->orHavingIn('c2', [$param2, $param3]);
// SELECT ... HAVING c1 = ? OR c2 IN (?, ?)
```

#### `havingNotIn`

```php
$stmt->havingNotIn('c1', [$param1, $param2]);
// SELECT ... HAVING NOT c1 IN (?, ?)
```

#### `orHavingNotIn`

```php
$stmt->having('c1', $param1)
->orHavingNotIn('c2', [$param2, $param3]);
// SELECT ... HAVING c1 = ? OR NOT c2 IN (?, ?)
```

#### `havingBetween`

```php
$stmt->havingBetween('c1', $param1, $param2);
// SELECT ... HAVING c1 BETWEEN ? AND ?
```

#### `orHavingBetween`

```php
$stmt->having('c1', $param1)
->orHavingBetween('c2', $param2, $param3);
// SELECT ... HAVING c1 = ? OR c2 BETWEEN ? AND ?
```

#### `havingNotBetween`

```php
$stmt->havingNotBetween('c1', $param1, $param2);
// SELECT ... HAVING NOT c1 BETWEEN ? AND ?
```

#### `orHavingNotBetween`

```php
$stmt->having('c1', $param1)
->orHavingNotBetween('c2', $param2, $param3);
// SELECT ... HAVING c1 = ? OR NOT c2 BETWEEN ? AND ?
```

#### `havingNull`

```php
$stmt->havingNull('c1');
// SELECT ... HAVING c1 IS NULL
```

#### `orHavingNull`

```php
$stmt->having('c1', $param)
->orHavingNull('c2');
// SELECT ... HAVING c1 = ? OR c2 IS NULL
```

#### `havingNotNull`

```php
$stmt->havingNotNull('c1');
// SELECT ... HAVING NOT c1 IS NULL
```

#### `orHavingNotNull`

```php
$stmt->having('c1', $param)
->orHavingNotNull('c2');
// SELECT ... HAVING c1 = ? OR NOT c2 IS NULL
```

#### `orderBy`

```php
$stmt->orderBy('c1');
// SELECT ... ORDER BY c1
```

```php
$stmt->orderBy('c1', 'c2');
// SELECT ... ORDER BY c1, c2
```

```php
$stmt->orderBy(['c1', 'c2']);
// SELECT ... ORDER BY c1, c2
```

#### `orderByDesc`

```php
$stmt->orderByDesc('c1');
// SELECT ... ORDER BY c1 DESC
```

#### `orderByNullsFirst`

`PostgreSQL` and `SQLite` only.

```php
$stmt->orderByNullsFirst('c1');
// SELECT ... ORDER BY c1 ASC NULLS FIRST
```

#### `orderByNullsLast`

`PostgreSQL` and `SQLite` only.

```php
$stmt->orderByNullsLast('c1');
// SELECT ... ORDER BY c1 ASC NULLS LAST
```

#### `orderByDescNullsFirst`

`PostgreSQL` and `SQLite` only.

```php
$stmt->orderByDescNullsFirst('c1');
// SELECT ... ORDER BY c1 DESC NULLS FIRST
```

#### `orderByDescNullsLast`

`PostgreSQL` and `SQLite` only.

```php
$stmt->orderByDescNullsLast('c1');
// SELECT ... ORDER BY c1 DESC NULLS LAST
```

#### `limit`

`MariaDB`, `MySQL`, `PostgreSQL` and `SQLite` only.

```php
$stmt->limit(10);
// SELECT ... LIMIT 10
```

```php
$stmt->limit(10, 5);
// SELECT ... LIMIT 10 OFFSET 5
```

`MariaDB` only.

```php
$stmt->limit(10)->rowsExamined(100);
// SELECT ... LIMIT 10 ROWS EXAMINED 100
```

#### `offsetFetch`

`MariaDB`, `PostgreSQL` and `SQLServer` only.

```php
$stmt->offsetFetch(5, 10);
// SELECT ... OFFSET 5 ROWS FETCH NEXT 10 ROWS ONLY
```

```php
$stmt->offsetFetch(5, 10)->withTies();
// SELECT ... OFFSET 5 ROWS FETCH NEXT 10 ROWS WITH TIES
```

#### `union`

```php
$stmt->union(function ($select)
{
    $select->from('t1');
});
// SELECT ... UNION SELECT * FROM t1
```

#### `unionAll`

```php
$stmt->unionAll(function ($select)
{
    $select->from('t1');
});
// SELECT ... UNION ALL SELECT * FROM t1
```

#### `intersect`

```php
$stmt->intersect(function ($select)
{
    $select->from('t1');
});
// SELECT ... INTERSECT SELECT * FROM t1
```

#### `intersectAll`

`MariaDB`, `MySQL`, and `PostgreSQL` only.

```php
$stmt->intersectAll(function ($select)
{
    $select->from('t1');
});
// SELECT ... INTERSECT ALL SELECT * FROM t1
```

#### `except`

```php
$stmt->except(function ($select)
{
    $select->from('t1');
});
// SELECT ... EXCEPT SELECT * FROM t1
```

#### `exceptAll`

`MariaDB`, `MySQL`, and `PostgreSQL` only.

```php
$stmt->exceptAll(function ($select)
{
    $select->from('t1');
});
// SELECT ... EXCEPT ALL SELECT * FROM t1
```

#### `window`

`MySQL`, `PostgreSQL`, `SQLite`, and `SQLServer` only.

See [Window](../components/window.md).

```php
$stmt->window('w1', function (Window $window)
{

});
// SELECT ... WINDOW w1 AS ()
```

#### `with`

See [CTE](../components/cte.md).

```php
use MichaelRushton\Database\SQL\Components\CTE;

$stmt->cte(
    'cte1',
    function ($select)
    {
        $select->from('t1');
    },
    function (CTE $cte)
    {

    }
);
// WITH cte1 AS (SELECT * FROM t1) SELECT
```

```php
use MichaelRushton\Database\SQL\Components\CTE;

$stmt->cte('cte1', 'SELECT * FROM t1')->recursive();
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) SELECT
```

#### `highPriority`

`MariaDB` and `MySQL` only.

```php
$stmt->highPriority();
// SELECT HIGH_PRIORITY
```

#### `straightJoinAll`

`MariaDB` and `MySQL` only.

```php
$stmt->straightJoinAll();
// SELECT STRAIGHT_JOIN
```

#### `sqlSmallResult`

`MariaDB` and `MySQL` only.

```php
$stmt->sqlSmallResult();
// SELECT SQL_SMALL_RESULT
```

#### `sqlBigResult`

`MariaDB` and `MySQL` only.

```php
$stmt->sqlBigResult();
// SELECT SQL_BIG_RESULT
```

#### `sqlBufferResult`

`MariaDB` and `MySQL` only.

```php
$stmt->sqlBufferResult();
// SELECT SQL_BUFFER_RESULT
```

#### `sqlCache`

`MariaDB` only.

```php
$stmt->sqlCache();
// SELECT SQL_CACHE
```

#### `sqlNoCache`

`MariaDB` only.

```php
$stmt->sqlNoCache();
// SELECT SQL_NO_CACHE
```

#### `sqlCalcFoundRows`

`MariaDB` and `MySQL` only.

```php
$stmt->sqlCalcFoundRows();
// SELECT SQL_CALC_FOUND_ROWS
```

#### `intoOutfile`

`MariaDB` and `MySQL` only.

See [Outfile](../components/outfile.md).

```php
use MichaelRushton\Database\SQL\Components\Outfile;

$stmt->intoOutfile('/path/to/file', function (Outfile $outfile)
{

});
// SELECT ... INTO OUTFILE '/path/to/file'
```

#### `intoDumpfile`

`MariaDB` and `MySQL` only.

```php
$stmt->intoDumpfile('/path/to/file');
// SELECT ... INTO DUMPFILE '/path/to/file'
```

#### `intoVar`

`MariaDB` and `MySQL` only.

```php
$stmt->intoVar('v1');
// SELECT ... INTO @v1
```

```php
$stmt->intoVar('v1', 'v2');
// SELECT ... INTO @v1, @v2
```

```php
$stmt->intoVar(['v1', 'v2']);
// SELECT ... INTO @v1, @v2
```

#### `into`

`SQLServer` only.

```php
$stmt->into('t2');
// SELECT ... INTO t2
```

#### `forUpdate`

`MariaDB`, `MySQL`, and `PostgreSQL` only.

```php
$stmt->forUpdate();
// SELECT ... FOR UPDATE
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdate('t1');
// SELECT ... FOR UPDATE OF t1
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdate('t1', 't2');
// SELECT ... FOR UPDATE OF t1, t2
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdate(['t1', 't2']);
// SELECT ... FOR UPDATE OF t1, t2
```

#### `forUpdateWait`

`MariaDB` only.

```php
$stmt->forUpdateWait(5);
// SELECT ... FOR UPDATE WAIT 5
```

#### `forUpdateNoWait`

`MariaDB`, `MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateNoWait();
// SELECT ... FOR UPDATE NOWAIT
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateNoWait('t1');
// SELECT ... FOR UPDATE OF t1 NOWAIT
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateNoWait('t1', 't2');
// SELECT ... FOR UPDATE OF t1, t2 NOWAIT
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateNoWait(['t1', 't2']);
// SELECT ... FOR UPDATE OF t1, t2 NOWAIT
```

#### `forUpdateSkipLocked`

`MariaDB`, `MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateSkipLocked();
// SELECT ... FOR UPDATE SKIP LOCKED
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateSkipLocked('t1');
// SELECT ... FOR UPDATE OF t1 SKIP LOCKED
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateSkipLocked('t1', 't2');
// SELECT ... FOR UPDATE OF t1, t2 SKIP LOCKED
```

`MySQL` and `PostgreSQL` only.

```php
$stmt->forUpdateSkipLocked(['t1', 't2']);
// SELECT ... FOR UPDATE OF t1, t2 SKIP LOCKED
```

#### `forNoKeyUpdate`

`PostgreSQL` only.

```php
$stmt->forNoKeyUpdate();
// SELECT ... FOR NO KEY UPDATE
```

```php
$stmt->forNoKeyUpdate('t1');
// SELECT ... FOR NO KEY UPDATE OF t1
```

```php
$stmt->forNoKeyUpdate('t1', 't2');
// SELECT ... FOR NO KEY UPDATE OF t1, t2
```

```php
$stmt->forNoKeyUpdate(['t1', 't2']);
// SELECT ... FOR NO KEY UPDATE OF t1, t2
```

#### `forNoKeyUpdateNoWait`

`PostgreSQL` only.

```php
$stmt->forNoKeyUpdateNoWait();
// SELECT ... FOR NO KEY UPDATE NOWAIT
```

```php
$stmt->forNoKeyUpdateNoWait('t1');
// SELECT ... FOR NO KEY UPDATE OF t1 NOWAIT
```

```php
$stmt->forNoKeyUpdateNoWait('t1', 't2');
// SELECT ... FOR NO KEY UPDATE OF t1, t2 NOWAIT
```

```php
$stmt->forNoKeyUpdateNoWait(['t1', 't2']);
// SELECT ... FOR NO KEY UPDATE OF t1, t2 NOWAIT
```

#### `forNoKeyUpdateSkipLocked`

`PostgreSQL` only.

```php
$stmt->forNoKeyUpdateSkipLocked();
// SELECT ... FOR NO KEY UPDATE SKIP LOCKED
```

```php
$stmt->forNoKeyUpdateSkipLocked('t1');
// SELECT ... FOR NO KEY UPDATE OF t1 SKIP LOCKED
```

```php
$stmt->forNoKeyUpdateSkipLocked('t1', 't2');
// SELECT ... FOR NO KEY UPDATE OF t1, t2 SKIP LOCKED
```

```php
$stmt->forNoKeyUpdateSkipLocked(['t1', 't2']);
// SELECT ... FOR NO KEY UPDATE OF t1, t2 SKIP LOCKED
```

#### `forShare`

`MySQL` and `PostgreSQL` only.

```php
$stmt->forShare();
// SELECT ... FOR SHARE
```

```php
$stmt->forShare('t1');
// SELECT ... FOR SHARE OF t1
```

```php
$stmt->forShare('t1', 't2');
// SELECT ... FOR SHARE OF t1, t2
```

```php
$stmt->forShare(['t1', 't2']);
// SELECT ... FOR SHARE OF t1, t2
```

#### `forShareNoWait`

`MySQL` and `PostgreSQL` only.

```php
$stmt->forShareNoWait();
// SELECT ... FOR SHARE NOWAIT
```

```php
$stmt->forShareNoWait('t1');
// SELECT ... FOR SHARE OF t1 NOWAIT
```

```php
$stmt->forShareNoWait('t1', 't2');
// SELECT ... FOR SHARE OF t1, t2 NOWAIT
```

```php
$stmt->forShareNoWait(['t1', 't2']);
// SELECT ... FOR SHARE OF t1, t2 NOWAIT
```

#### `forShareSkipLocked`

`MySQL` and `PostgreSQL` only.

```php
$stmt->forShareSkipLocked();
// SELECT ... FOR SHARE SKIP LOCKED
```

```php
$stmt->forShareSkipLocked('t1');
// SELECT ... FOR SHARE OF t1 SKIP LOCKED
```

```php
$stmt->forShareSkipLocked('t1', 't2');
// SELECT ... FOR SHARE OF t1, t2 SKIP LOCKED
```

```php
$stmt->forShareSkipLocked(['t1', 't2']);
// SELECT ... FOR SHARE OF t1, t2 SKIP LOCKED
```

#### `forKeyShare`

`PostgreSQL` only.

```php
$stmt->forKeyShare();
// SELECT ... FOR KEY SHARE
```

```php
$stmt->forKeyShare('t1');
// SELECT ... FOR KEY SHARE OF t1
```

```php
$stmt->forKeyShare('t1', 't2');
// SELECT ... FOR KEY SHARE OF t1, t2
```

```php
$stmt->forKeyShare(['t1', 't2']);
// SELECT ... FOR KEY SHARE OF t1, t2
```

#### `forKeyShareNoWait`

`PostgreSQL` only.

```php
$stmt->forKeyShareNoWait();
// SELECT ... FOR KEY SHARE NOWAIT
```

```php
$stmt->forKeyShareNoWait('t1');
// SELECT ... FOR KEY SHARE OF t1 NOWAIT
```

```php
$stmt->forKeyShareNoWait('t1', 't2');
// SELECT ... FOR KEY SHARE OF t1, t2 NOWAIT
```

```php
$stmt->forKeyShareNoWait(['t1', 't2']);
// SELECT ... FOR KEY SHARE OF t1, t2 NOWAIT
```

#### `forKeyShareSkipLocked`

`PostgreSQL` only.

```php
$stmt->forKeyShareSkipLocked();
// SELECT ... FOR KEY SHARE SKIP LOCKED
```

```php
$stmt->forKeyShareSkipLocked('t1');
// SELECT ... FOR KEY SHARE OF t1 SKIP LOCKED
```

```php
$stmt->forKeyShareSkipLocked('t1', 't2');
// SELECT ... FOR KEY SHARE OF t1, t2 SKIP LOCKED
```

```php
$stmt->forKeyShareSkipLocked(['t1', 't2']);
// SELECT ... FOR KEY SHARE OF t1, t2 SKIP LOCKED
```

#### `lockInShareMode`

`MariaDB` and `MySQL` only.

```php
$stmt->lockInShareMode();
// SELECT ... LOCK IN SHARE MODE
```

#### `lockInShareModeWait`

`MariaDB` only.

```php
$stmt->lockInShareModeWait(5);
// SELECT ... LOCK IN SHARE MODE WAIT 5
```

#### `lockInShareModeNoWait`

`MariaDB` only.

```php
$stmt->lockInShareModeNoWait();
// SELECT ... LOCK IN SHARE MODE NOWAIT
```

#### `lockInShareModeSkipLocked`

`MariaDB` only.

```php
$stmt->lockInShareModeSkipLocked();
// SELECT ... LOCK IN SHARE MODE SKIP LOCKED
```
