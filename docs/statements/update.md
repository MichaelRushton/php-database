# PHP Database

[Go back](../../README.md)

## `UPDATE`

```php
$stmt = $connection->update();
// UPDATE ...
```

#### `top`

`SQLServer` only.

```php
$stmt->top(10);
// UPDATE TOP (10) ...
```

```php
$stmt->top(10)->percent();
// UPDATE TOP (10) PERCENT ...
```

#### `table`

```php
$stmt->table('t1');
// UPDATE t1
```

```php
$stmt->table('t1', 't2');
// UPDATE t1, t2
```

```php
$stmt->table(['a' => 't1', 'b' => 't2']);
// UPDATE t1 a, t2 b
```

See [Subquery](../components/subquery.md).

```php
$stmt->table(
    $connection->select()
    ->columns('c1')
    ->from('t1')
);
// UPDATE (SELECT c1 FROM t1)
```

See [Table](../components/table.md).

```php
use MichaelRushton\Database\SQL\Components\Table;

$stmt->table(new Table('t1'));
// UPDATE t1
```

#### `set`

```php
$stmt->set('c1', $param);
// UPDATE ... SET c1 = ?
```

```php
$stmt->set([
    'c1' => $param1,
    'c2' => $param2,
]);
// UPDATE ... SET c1 = ?, c2 = ?
```

#### `join`

See [join](./select.md#join).

```php
$stmt->join('t2');
// UPDATE ... JOIN t2
```

#### `where`

See [where](./select.md#where).

```php
$stmt->where('c1', $param);
// UPDATE ... WHERE c1 = ?
```

#### `whereCurrentOf`

`PostgreSQL` and `SQLServer` only.

```php
$stmt->whereCurrentOf('cursor');
// UPDATE ... WHERE CURRENT OF cursor
```

#### `orderBy`

`MariaDB`, `MySQL` and `SQLite` only.

See [order by](./select.md#orderby).

```php
$stmt->orderBy('c1');
// UPDATE ... ORDER BY c1
```

#### `limit`

`MariaDB`, `MySQL`, and `SQLite` only.

See [limit](./select.md#limit).

```php
$stmt->limit(10);
// UPDATE ... LIMIT 10
```

#### `with`

See [with](./select#with).

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
// WITH cte1 AS (SELECT * t1) UPDATE ...
```

#### `lowPriority`

`MariaDB` and `MySQL` only.

```php
$stmt->lowPriority();
// UPDATE LOW_PRIORITY ...
```

#### `ignore`

`MariaDB` and `MySQL` only.

```php
$stmt->ignore();
// UPDATE IGNORE ...
```

#### `orFail`

`SQLite` only.

```php
$stmt->orFail();
// UPDATE OR FAIL ...
```

#### `orIgnore`

`SQLite` only.

```php
$stmt->orIgnore();
// UPDATE OR IGNORE ...
```

#### `orReplace`

`SQLite` only.

```php
$stmt->orReplace();
// UPDATE OR REPLACE ...
```

#### `orRollBack`

`SQLite` only.

```php
$stmt->orRollBack();
// UPDATE OR ROLLBACK ...
```

#### `from`

`PostgreSQL`, `SQLite`, and `SQLServer` only.

See [from](./select.md#from).

```php
$stmt->from('t1');
// UPDATE ... FROM t1
```

#### `returning`

See [returning](./insert.md#returning).

`MariaDB`, `PostgreSQL` and `SQLite` only.

```php
$stmt->returning();
// UPDATE ... RETURNING *
```

#### `output`

`SQLServer` only.

```php
$stmt->output('INSERTED.c1', 'DELETED.c1');
// UPDATE ... OUTPUT INSERTED.c1, DELETED.c1 ...
```

```php
$stmt->output(['a' => 'INSERTED.c1', 'b' => 'DELETED.c1']);
// UPDATE ... OUTPUT INSERTED.c1 a, DELETED.c1 b ...
```
