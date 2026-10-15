# PHP Database

[Go back](../statements/select.md)

## `CTE`

```php
use MichaelRushton\Database\SQL\Components\Table;

$table = new Table('t1');
// t1
```

#### `only`

```php
$table->only();
// ONLY t1
```

#### `partition`

```php
$table->partition('p1');
// t1 PARTITION (p1)
```

```php
$table->partition('p1', 'p2');
// t1 PARTITION (p1, p2)
```

```php
$table->partition(['p1', 'p2']);
// t1 PARTITION (p1, p2)
```

#### `forPortionOf`

```php
$table->forPortionOf('date_period', '2025-01-01', '2025-01-31');
// t1 FOR PORTION OF date_period FROM '2025-01-01' TO '2025-01-31'
```

```php
$table->forPortionOf('date_period', new \DateTime('2025-01-01'), new \DateTime('2025-01-31'));
// t1 FOR PORTION OF date_period FROM '2025-01-01 00:00:00' TO '2025-01-31 00:00:00'
```

#### `as`

```php
$table->as('t2');
// t1 t2
```

#### `useIndex`

```php
$table->useIndex();
// t1 USE INDEX ()
```

```php
$table->useIndex('i1');
// t1 USE INDEX (i1)
```

```php
$table->useIndex('i1', 'i2');
// t1 USE INDEX (i1, i2)
```

```php
$table->useIndex(['i1', 'i2']);
// t1 USE INDEX (i1, i2)
```

#### `useIndexForOrderBy`

```php
$table->useIndexForOrderBy();
// t1 USE INDEX FOR ORDER BY ()
```

```php
$table->useIndexForOrderBy('i1');
// t1 USE INDEX FOR ORDER BY (i1)
```

```php
$table->useIndexForOrderBy('i1', 'i2');
// t1 USE INDEX FOR ORDER BY (i1, i2)
```

```php
$table->useIndexForOrderBy(['i1', 'i2']);
// t1 USE INDEX FOR ORDER BY (i1, i2)
```

#### `useIndexForGroupBy`

```php
$table->useIndexForGroupBy();
// t1 USE INDEX FOR GROUP BY ()
```

```php
$table->useIndexForGroupBy('i1');
// t1 USE INDEX FOR GROUP BY (i1)
```

```php
$table->useIndexForGroupBy('i1', 'i2');
// t1 USE INDEX FOR GROUP BY (i1, i2)
```

```php
$table->useIndexForGroupBy(['i1', 'i2']);
// t1 USE INDEX FOR GROUP BY (i1, i2)
```

#### `ignoreIndex`

```php
$table->ignoreIndex('i1');
// t1 IGNORE INDEX (i1)
```

```php
$table->ignoreIndex('i1', 'i2');
// t1 IGNORE INDEX (i1, i2)
```

```php
$table->ignoreIndex(['i1', 'i2']);
// t1 IGNORE INDEX (i1, i2)
```

#### `ignoreIndexForOrderBy`

```php
$table->ignoreIndexForOrderBy('i1');
// t1 IGNORE INDEX FOR ORDER BY (i1)
```

```php
$table->ignoreIndexForOrderBy('i1', 'i2');
// t1 IGNORE INDEX FOR ORDER BY (i1, i2)
```

```php
$table->ignoreIndexForOrderBy(['i1', 'i2']);
// t1 IGNORE INDEX FOR ORDER BY (i1, i2)
```

#### `ignoreIndexForGroupBy`

```php
$table->ignoreIndexForGroupBy('i1');
// t1 IGNORE INDEX FOR GROUP BY (i1)
```

```php
$table->ignoreIndexForGroupBy('i1', 'i2');
// t1 IGNORE INDEX FOR GROUP BY (i1, i2)
```

```php
$table->ignoreIndexForGroupBy(['i1', 'i2']);
// t1 IGNORE INDEX FOR GROUP BY (i1, i2)
```

#### `forceIndex`

```php
$table->forceIndex('i1');
// t1 FORCE INDEX (i1)
```

```php
$table->forceIndex('i1', 'i2');
// t1 FORCE INDEX (i1, i2)
```

```php
$table->forceIndex(['i1', 'i2']);
// t1 FORCE INDEX (i1, i2)
```

#### `forceIndexForOrderBy`

```php
$table->forceIndexForOrderBy('i1');
// t1 FORCE INDEX FOR ORDER BY (i1)
```

```php
$table->forceIndexForOrderBy('i1', 'i2');
// t1 FORCE INDEX FOR ORDER BY (i1, i2)
```

```php
$table->forceIndexForOrderBy(['i1', 'i2']);
// t1 FORCE INDEX FOR ORDER BY (i1, i2)
```

#### `forceIndexForGroupBy`

```php
$table->forceIndexForGroupBy('i1');
// t1 FORCE INDEX FOR GROUP BY (i1)
```

```php
$table->forceIndexForGroupBy('i1', 'i2');
// t1 FORCE INDEX FOR GROUP BY (i1, i2)
```

```php
$table->forceIndexForGroupBy(['i1', 'i2']);
// t1 FORCE INDEX FOR GROUP BY (i1, i2)
```
