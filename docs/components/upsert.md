# PHP Database

[Go back](../statements/insert.md)

## `Upsert`

```php
use MichaelRushton\Database\SQL\Components\Upsert;

$stmt->onConflictDoUpdateSet('c1', $param, function (Upsert $upsert)
{

});
// INSERT ... ON CONFLICT DO UPDATE SET c1 = ?
```

#### `columns`

```php
$upsert->columns('c1');
// ON CONFLICT (c1) DO UPDATE SET c1 = ?
```

```php
$upsert->columns('c1', 'c2');
// ON CONFLICT (c1, c2) DO UPDATE SET c1 = ?
```

```php
$upsert->columns(['c1', 'c2']);
// ON CONFLICT (c1, c2) DO UPDATE SET c1 = ?
```

#### `whereIndex`

See [where](../statements/select.md#where).

```php
$upsert->whereIndex('c1', $param);
// ON CONFLICT (c1) WHERE c1 = ? DO UPDATE SET c1 = ?
```

#### `onConstraint`

```php
$upsert->onConstraint('constraint');
// ON CONFLICT ON CONSTRAINT constraint DO UPDATE SET c1 = ?
```

#### `where`

See [where](../statements/select.md#where).

```php
$upsert->where('c1', $param);
// ON CONFLICT (c1) DO UPDATE SET c1 = ? WHERE c1 = ?
```
