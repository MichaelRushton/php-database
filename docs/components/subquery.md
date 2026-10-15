# PHP Database

[Go back](../statements/select.md)

## `Subquery`

```php
$subquery = $connection->select()->from('t1')->toSubquery();
// (SELECT * FROM t1)
```

#### `all`

```php
$subquery->all();
// ALL (SELECT * FROM t1)
```

#### `any`

```php
$subquery->any();
// ANY (SELECT * FROM t1)
```

#### `exists`

```php
$subquery->exists();
// EXISTS (SELECT * FROM t1)
```

#### `in`

```php
$subquery->in();
// IN (SELECT * FROM t1)
```

#### `lateral`

```php
$subquery->lateral();
// LATERAL (SELECT * FROM t1)
```

#### `as`

```php
$subquery->as('s1');
// (SELECT * FROM t1) s1
```

#### `columns`

```php
$subquery->columns('c1');
// (SELECT * FROM t1) (c1)
```

```php
$subquery->columns('c1', 'c2');
// (SELECT * FROM t1) (c1, c2)
```

```php
$subquery->columns(['c1', 'c2']);
// (SELECT * FROM t1) (c1, c2)
```
