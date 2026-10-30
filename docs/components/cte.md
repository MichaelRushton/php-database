# PHP Database

[Go back](../statements/select.md)

## `CTE`

```php
use MichaelRushton\Database\SQL\Components\CTE;

$stmt->with('cte1', fn ($select) => $select->from('t1'), function (CTE $cte)
{

});
// WITH cte1 AS (SELECT * FROM t1) SELECT ...
```

#### `columns`

```php
$cte->columns('c1');
// WITH cte1 (c1) AS (SELECT * FROM t1) SELECT ...
```

```php
$cte->columns('c1', 'c2');
// WITH cte1 (c1, c2) AS (SELECT * FROM t1) SELECT ...
```

```php
$cte->columns(['c1', 'c2']);
// WITH cte1 (c1, c2) AS (SELECT * FROM t1) SELECT ...
```

#### `materialized`

```php
$cte->materialized();
// WITH cte1 AS MATERIALIZED (SELECT * FROM t1) SELECT ...
```

#### `notMaterialized`

```php
$cte->notMaterialized();
// WITH cte1 AS NOT MATERIALIZED (SELECT * FROM t1) SELECT ...
```

#### `cycleRestrict`

```php
$cte->cycleRestrict('c1');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) CYCLE c1 RESTRICT SELECT ...
```

```php
$cte->cycleRestrict('c1', 'c2');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) CYCLE c1, c2 RESTRICT SELECT ...
```

```php
$cte->cycleRestrict(['c1', 'c2']);
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) CYCLE c1, c2 RESTRICT SELECT ...
```

#### `searchBreadth`

```php
$cte->searchBreadth('c1', 'ordercol');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) SEARCH BREADTH FIRST BY c1 SET ordercol SELECT ...
```

```php
$cte->searchBreadth(['c1', 'c2'], 'ordercol');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) SEARCH BREADTH FIRST BY c1, c2 SET ordercol SELECT ...
```

#### `searchDepth`

```php
$cte->searchDepth('c1', 'ordercol');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) SEARCH DEPTH FIRST BY c1 SET ordercol SELECT ...
```

```php
$cte->searchDepth(['c1', 'c2'], 'ordercol');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) SEARCH DEPTH FIRST BY c1, c2 SET ordercol SELECT ...
```

#### `cycle`

```php
$cte->cycle('c1');
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) CYCLE c1 SET is_cycle USING path SELECT ...
```

```php
$cte->cycle(['c1', 'c2']);
// WITH RECURSIVE cte1 AS (SELECT * FROM t1) CYCLE c1, c2 SET is_cycle USING path SELECT ...
```
