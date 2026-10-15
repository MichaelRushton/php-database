# PHP Database

[Go back](../../README.md)

## `INSERT`

```php
$stmt = $connection->insert();
// INSERT ... VALUES () -- MariaDB and MySQL
// INSERT ... DEFAULT VALUES -- PostgreSQL, SQLite, and SQLServer
```

#### `into`

```php
$stmt->into('t1');
// INSERT INTO t1 ...
```

#### `columns`

```php
$stmt->columns('c1');
// INSERT ... (c1)
```

```php
$stmt->columns('c1', 'c2');
// INSERT ... (c1, c2)
```

```php
$stmt->columns(['c1', 'c2']);
// INSERT ... (c1, c2)
```

#### `values`

```php
$stmt->values([$param1, $param2]);
// INSERT ... VALUES (?, ?)
```

```php
use MichaelRushton\Database\SQL\Components\Raw;

$stmt->values([new Raw('DEFAULT')]);
// INSERT ... VALUES (DEFAULT)
```

```php
$stmt->values([
    [$param1, $param2],
    [$param3, $param4],
]);
// INSERT ... VALUES (?, ?), (?, ?)
```

```php
$stmt->values([[
    'c1' => $param1,
    'c2' => $param2,
], [
    'c1' => $param3,
    'c2' => $param4,
]]);
// INSERT ... (c1, c2) VALUES (?, ?), (?, ?)
```

#### `select`

See [SELECT](./select.md).

```php
$stmt->select(function ($select)
{

});
// INSERT ... SELECT * ...
```

#### `with`

`PostgreSQL`, `SQLite`, and `SQLServer` only.

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
// WITH cte1 AS (SELECT * FROM t1) INSERT ...
```

#### `lowPriority`

`MariaDB` and `MySQL` only.

```php
$stmt->lowPriority();
// INSERT LOW_PRIORITY ...
```

#### `delayed`

`MariaDB` only.

```php
$stmt->delayed();
// INSERT DELAYED ...
```

#### `highPriority`

`MariaDB` and `MySQL` only.

```php
$stmt->highPriority();
// INSERT HIGH_PRIORITY ...
```

#### `ignore`

`MariaDB` and `MySQL` only.

```php
$stmt->ignore();
// INSERT IGNORE ...
```

#### `orFail`

`SQLite` only.

```php
$stmt->orFail();
// INSERT OR FAIL ...
```

#### `orIgnore`

`SQLite` only.

```php
$stmt->orIgnore();
// INSERT OR IGNORE ...
```

#### `orReplace`

`SQLite` only.

```php
$stmt->orReplace();
// INSERT OR REPLACE ...
```

#### `orRollBack`

`SQLite` only.

```php
$stmt->orRollBack();
// INSERT OR ROLLBACK ...
```

#### `top`

`SQLServer` only.

```php
$stmt->top(10);
// INSERT TOP (10) ...
```

```php
$stmt->top(10)->percent();
// INSERT TOP (10) PERCENT ...
```

#### `overridingSystemValue`

`PostgreSQL` only.

```php
$stmt->overridingSystemValue();
// INSERT ... OVERRIDING SYSTEM VALUE ...
```

#### `overridingUserValue`

`PostgreSQL` only.

```php
$stmt->overridingUserValue();
// INSERT ... OVERRIDING USER VALUE ...
```

#### `output`

`SQLServer` only.

```php
$stmt->output('INSERTED.c1', 'INSERTED.c2');
// INSERT ... OUTPUT INSERTED.c1, INSERTED.c2 ...
```

```php
$stmt->output(['a' => 'INSERTED.c1', 'b' => 'INSERTED.c2']);
// INSERT ... OUTPUT INSERTED.c1 a, INSERTED.c2 b ...
```

#### `set`

`MariaDB` and `MySQL` only.

See [UPDATE](./update.md#set).

```php
$stmt->set('c1', $param);
// INSERT ... SET c1 = ?
```

#### `as`

`MySQL` only.

```php
$stmt->as('new');
// INSERT ... AS new
```

```php
$stmt->as('new', 'a');
// INSERT ... AS new (a)
```

```php
$stmt->as('new', ['a', 'b']);
// INSERT ... AS new (a, b)
```

#### `onConflictDoNothing`

`PostgreSQL` and `SQLite` only.

See [Upsert](../components/upsert.md).

```php
use MichaelRushton\Database\SQL\Components\Upsert;

$stmt->onConflictDoNothing(function (Upsert $upsert)
{

});
// INSERT ... ON CONFLICT DO NOTHING
```

#### `onConflictDoUpdateSet`

`PostgreSQL` and `SQLite` only.

See [Upsert](../components/upsert.md).

```php
use MichaelRushton\Database\SQL\Components\Upsert;

$stmt->onConflictDoUpdateSet('c1', $param, function (Upsert $upsert)
{

});
// INSERT ... ON CONFLICT DO UPDATE SET c1 = ?
```

#### `onDuplicateKeyUpdate`

`MariaDB` and `MySQL` only.

```php
$stmt->onDuplicateKeyUpdate('c1', $param);
// INSERT ... ON DUPLICATE KEY UPDATE c1 = ?
```

```php
$stmt->onDuplicateKeyUpdate([
    'c1' => $param1,
    'c2' => $param2,
]);
// INSERT ... ON DUPLICATE KEY UPDATE c1 = ?, c2 = ?
```

#### `returning`

`MariaDB`, `PostgreSQL`, and `SQLite` only.

```php
$stmt->returning();
// INSERT ... RETURNING *
```

```php
$stmt->returning('c1', 'c2');
// INSERT ... RETURNING c1, c2
```

```php
$stmt->returning(['a' => 'c1', 'b' => 'c2']);
// INSERT ... RETURNING c1 a, c2 b
```
