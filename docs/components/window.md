# PHP Database

[Go back](../statements/select.md)

## `Window`

```php
use MichaelRushton\Database\SQL\Components\Window;

$stmt->window('w1', function (Window $window)
{

});
// SELECT ... WINDOW w1 AS ()
```

#### `specName`

```php
$window->specName('w2');
// w1 AS (w2)
```

#### `partitionBy`

```php
$window->partitionBy('c1');
// w1 AS (PARTITION BY c1)
```

```php
$window->partitionBy('c1', 'c2');
// w1 AS (PARTITION BY c1, c2)
```

```php
$window->partitionBy(['c1', 'c2']);
// w1 AS (PARTITION BY c1, c2)
```

#### `orderBy`

See [orderBy](../statements/select.md#orderBy).

```php
$window->orderBy('c1');
// w1 AS (ORDER BY c1)
```

```php
$window->orderBy('c1', 'c2');
// w1 AS (ORDER BY c1, c2)
```

```php
$window->orderBy(['c1', 'c2']);
// w1 AS (ORDER BY c1, c2)
```

#### `orderByDesc`

```php
$window->orderByDesc('c1');
// w1 AS (ORDER BY c1 DESC)
```

#### `orderByNullsFirst`

```php
$window->orderByNullsFirst('c1');
// w1 AS (ORDER BY c1 ASC NULLS FIRST)
```

#### `orderByNullsLast`

```php
$window->orderByNullsLast('c1');
// w1 AS (ORDER BY c1 ASC NULLS LAST)
```

#### `orderByDescNullsFirst`

```php
$window->orderByDescNullsFirst('c1');
// w1 AS (ORDER BY c1 DESC NULLS FIRST)
```

#### `orderByDescNullsLast`

```php
$window->orderByDescNullsLast('c1');
// w1 AS (ORDER BY c1 DESC NULLS LAST)
```

#### `range`

```php
$window->range();
// w1 AS (... RANGE ...)
```

#### `rows`

```php
$window->rows();
// w1 AS (... ROWS ...)
```

#### `groups`

```php
$window->groups();
// w1 AS (... GROUPS ...)
```

#### `currentRow`

```php
$window->currentRow();
// w1 AS (... CURRENT ROW)
```

#### `unboundedPreceding`

```php
$window->unboundedPreceding();
// w1 AS (... UNBOUNDED PRECEDING)
```

#### `unboundedFollowing`

```php
$window->unboundedFollowing();
// w1 AS (... UNBOUNDED FOLLOWING)
```

#### `preceding`

```php
$window->preceding(10);
// w1 AS (... 10 PRECEDING)
```

#### `following`

```php
$window->following(10);
// w1 AS (... 10 FOLLOWING)
```

#### `betweenCurrentRow`

```php
$window->betweenCurrentRow();
// w1 AS (... BETWEEN CURRENT ROW ...)
```

#### `betweenUnboundedPreceding`

```php
$window->betweenUnboundedPreceding();
// w1 AS (... BETWEEN UNBOUNDED PRECEDING ...)
```

#### `betweenUnboundedFollowing`

```php
$window->betweenUnboundedFollowing();
// w1 AS (... BETWEEN UNBOUNDED FOLLOWING ...)
```

#### `betweenPreceding`

```php
$window->betweenPreceding(10);
// w1 AS (... BETWEEN 10 PRECEDING ...)
```

#### `betweenFollowing`

```php
$window->betweenFollowing(10);
// w1 AS (... BETWEEN 10 FOLLOWING ...)
```

#### `andCurrentRow`

```php
$window->andCurrentRow();
// w1 AS (... AND CURRENT ROW)
```

#### `andUnboundedPreceding`

```php
$window->andUnboundedPreceding();
// w1 AS (... AND UNBOUNDED PRECEDING)
```

#### `andUnboundedFollowing`

```php
$window->andUnboundedFollowing();
// w1 AS (... AND UNBOUNDED FOLLOWING)
```

#### `andPreceding`

```php
$window->andPreceding(10);
// w1 AS (... AND 10 PRECEDING)
```

#### `andFollowing`

```php
$window->andFollowing(10);
// w1 AS (... AND 10 FOLLOWING)
```

#### `excludeCurrentRow`

```php
$window->excludeCurrentRow();
// w1 AS (... EXCLUDE CURRENT ROW)
```

#### `excludeGroup`

```php
$window->excludeGroup();
// w1 AS (... EXCLUDE GROUP)
```

#### `excludeNoOthers`

```php
$window->excludeNoOthers();
// w1 AS (... EXCLUDE NO OTHERS)
```

#### `excludeTies`

```php
$window->excludeTies();
// w1 AS (... EXCLUDE TIES)
```
