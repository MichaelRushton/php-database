# PHP Database

A PHP library to access a database.

## Installation

```bash
composer require michaelrushton/database
```

## Documentation

### MariaDB

```php
use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Drivers\MariaDBDriver;

$connection = new MariaDBConnection(new MariaDBDriver());
```

Driver arguments

```php
$driver = new MariaDBDriver(
    $username,
    $password,
    $host,
    $port,
    $dbname,
    $unix_socket,
    $charset,
    $pdo_options
);
```

### MySQL

```php
use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Drivers\MySQLDriver;

$connection = new MySQLConnection(new MySQLDriver());
```

#### Driver arguments

```php
$driver = new MySQLDriver(
    $username,
    $password,
    $host,
    $port,
    $dbname,
    $unix_socket,
    $charset,
    $pdo_options
);
```

### PostgreSQL

```php
use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Drivers\PostgreSQLDriver;

$connection = new PostgreSQLConnection(new PostgreSQLDriver());
```

#### Driver arguments

```php
$driver = new PostgreSQLDriver(
    $username,
    $password,
    $host,
    $port,
    $dbname,
    $sslmode,
    $pdo_options
);
```

### SQLite

```php
use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;

$connection = new SQLiteConnection(new SQLiteDriver());
```

#### Driver arguments

```php
$driver = new SQLiteDriver(
    $database,
    $pdo_options
);
```

### SQLServer

```php
use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Drivers\SQLServerDriver;

$connection = new SQLServerConnection(new SQLServerDriver());
```

#### Driver arguments

```php
$driver = new SQLServerDriver(
    $username,
    $password,
    $Server,
    $AccessToken,
    $APP,
    $ApplicationIntent,
    $AttachDBFileName,
    $Authentication,
    $ColumnEncryption,
    $ConnectionPooling,
    $ConnectRetryCount,
    $ConnectRetryInterval,
    $Database,
    $Driver,
    $Encrypt,
    $Failover_Partner,
    $KeyStoreAuthentication,
    $KeyStorePrincipalId,
    $KeyStoreSecret,
    $Language,
    $LoginTimeout,
    $MultipleActiveResultSets,
    $MultiSubnetFailover,
    $QuotedId,
    $Scrollable,
    $TraceFile,
    $TraceOn,
    $TransactionIsolation,
    $TransparentNetworkIPResolution,
    $TrustServerCertificate,
    $WSID,
    $pdo_options
);
```

### Connection

#### `driver`

```php
$driver = $connection->driver();
```

#### `connect`

See https://www.php.net/manual/en/pdo.connect.php. Will not reconnect if a connection is open.

```php
$connection->connect();
```

#### `pdo`

```php
$pdo = $connection->pdo();
```

#### `exec`

See https://www.php.net/manual/en/pdo.exec.php.

```php
$count = $connection->exec("DELETE FROM users");
```

#### `query`

See https://www.php.net/manual/en/pdo.query.php.

```php
$pdo_stmt = $connection->query("SELECT * FROM users");
$pdo_stmt = $connection->query("SELECT * FROM users", $fetchMode, ...$fetchModeArgs);
```

#### `prepare`

See https://www.php.net/manual/en/pdo.prepare.php.

```php
$pdo_stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
$pdo_stmt = $connection->prepare("SELECT * FROM users WHERE id = ?", $options);
```

#### `bindValues`

See https://www.php.net/manual/en/pdostatement.bindvalue.php.

```php
$pdo_stmt = $connection->bindValues("SELECT * FROM users WHERE id = ?", [1]);
```

#### `execute`

See https://www.php.net/manual/en/pdostatement.execute.php.

```php
$pdo_stmt = $connection->execute("SELECT * FROM users WHERE id = ?", [1]);
```

#### `fetch`

See https://www.php.net/manual/en/pdostatement.fetch.php.

```php
$user = $connection->fetch("SELECT * FROM users WHERE id = ?", [1]);
$user = $connection->fetch("SELECT * FROM users WHERE id = ?", [1], $mode, $cursorOrientation, $cursorOffset);
```

#### `fetchAll`

See https://www.php.net/manual/en/pdostatement.fetchall.php.

```php
$users = $connection->fetchAll("SELECT * FROM users WHERE active = ?", [1]);
$users = $connection->fetchAll("SELECT * FROM users WHERE active = ?", [1], $mode, ...$args);
```

#### `fetchColumn`

See https://www.php.net/manual/en/pdostatement.fetchcolumn.php.

```php
$id = $connection->fetchColumn("SELECT * FROM users WHERE id = ?", [1]);
$id = $connection->fetchColumn("SELECT * FROM users WHERE id = ?", [1], $column);
```

#### `fetchObject`

See https://www.php.net/manual/en/pdostatement.fetchobject.php.

```php
$user = $connection->fetchObject("SELECT * FROM users WHERE id = ?", [1]);
$user = $connection->fetchObject("SELECT * FROM users WHERE id = ?", [1], $class, $constructorArgs);
```

#### `yield`

See https://www.php.net/manual/en/pdostatement.fetch.php.

```php
$generator = $connection->yield("SELECT * FROM users WHERE active = ?", [1]);
$generator = $connection->yield("SELECT * FROM users WHERE active = ?", [1], $mode, $cursorOrientation, $cursorOffset);
```

#### `transaction`

Begins a transaction, rolls back if an exception is thrown (rethrowing the exception), else commits.

```php
use MichaelRushton\Database\Connections\SQLiteConnection;

$connection->transaction(function (SQLiteConnection $connection)
{
    $connection->query("INSERT INTO users (id) VALUES (1)");
    $connection->query("INSERT INTO users (id) VALUES (2)");
});
```

#### `close`

```php
$connection->close();
```

#### `when`

```php
use MichaelRushton\Database\Connections\SQLiteConnection;

$connection->when(
    value: $value,
    if_true: function (SQLiteConnection $connection, $value) {
        // ...
    },
    if_false: function (SQLiteConnection $connection, $value) {
        // ...
    }
);
```

#### `pipe`

```php
use MichaelRushton\Database\Connections\SQLiteConnection;

$return = $connection->pipe(function (SQLiteConnection $connection) {
    // ...
    return true;
});
```

#### `through`

```php
use MichaelRushton\Database\Connections\SQLiteConnection;

$connection->through(function (SQLiteConnection $connection) {
    // ...
});
```

#### `delete`

See [DELETE](./docs/statements/delete.md).

```php
$stmt = $connection->delete();
```

#### `insert`

See [INSERT](./docs/statements/insert.md).

```php
$stmt = $connection->insert();
```

#### `replace`

See [REPLACE](./docs/statements/replace.md). `MariaDB`, `MySQL`, and `SQLite` only.

```php
$stmt = $connection->replace();
```

#### `select`

See [SELECT](./docs/statements/select.md).

```php
$stmt = $connection->select();
```

#### `update`

See [UPDATE](./docs/statements/update.md).

```php
$stmt = $connection->update();
```

### Statement

#### `connection`

```php
$connection = $stmt->connection();
```

#### `exec`

See https://www.php.net/manual/en/pdo.exec.php.

```php
$count = $stmt->delete()->from('users')->exec();
```

#### `query`

See https://www.php.net/manual/en/pdo.query.php.

```php
$pdo_stmt = $stmt->select()->from('users')->query();
$pdo_stmt = $stmt->select()->from('users')->query($fetchMode, ...$fetchModeArgs);
```

#### `prepare`

See https://www.php.net/manual/en/pdo.prepare.php.

```php
$pdo_stmt = $stmt->select()->from('users')->where('id = ?')->prepare();
$pdo_stmt = $stmt->select()->from('users')->where('id = ?')->prepare($options);
```

#### `bindValues`

See https://www.php.net/manual/en/pdostatement.bindvalue.php.

```php
$pdo_stmt = $stmt->select()->from('users')->where('id', 1)->bindValues();
```

#### `execute`

See https://www.php.net/manual/en/pdostatement.execute.php.

```php
$pdo_stmt = $stmt->select()->from('users')->where('id', 1)->execute();
```

#### `fetch`

See https://www.php.net/manual/en/pdostatement.fetch.php.

```php
$user = $stmt->select()->from('users')->where('id', 1)->fetch();
$user = $stmt->select()->from('users')->where('id', 1)->fetch($mode, $cursorOrientation, $cursorOffset);
```

#### `fetchAll`

See https://www.php.net/manual/en/pdostatement.fetchall.php.

```php
$users = $stmt->select()->from('users')->where('active', 1)->fetchAll();
$users = $stmt->select()->from('users')->where('active', 1)->fetchAll($mode, ...$args);
```

#### `fetchColumn`

See https://www.php.net/manual/en/pdostatement.fetchcolumn.php.

```php
$id = $stmt->select()->from('users')->where('id', 1)->fetchColumn();
$id = $stmt->select()->from('users')->where('id', 1)->fetchColumn($column);
```

#### `fetchObject`

See https://www.php.net/manual/en/pdostatement.fetchobject.php.

```php
$user = $stmt->select()->from('users')->where('id', 1)->fetchObject();
$user = $stmt->select()->from('users')->where('id', 1)->fetchObject($class, $constructorArgs);
```

#### `yield`

See https://www.php.net/manual/en/pdostatement.fetch.php.

```php
$generator = $stmt->select()->from('users')->where('active', 1)->yield();
$generator = $stmt->select()->from('users')->where('active', 1)->yield($mode, $cursorOrientation, $cursorOffset);
```

#### `when`

```php
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

$stmt->when(
    value: $value,
    if_true: function (SQLiteSelect $stmt, $value) {
        // ...
    },
    if_false: function (SQLiteSelect $stmt, $value) {
        // ...
    }
);
```

#### `pipe`

```php
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

$return = $stmt->pipe(function (SQLiteSelect $stmt) {
    // ...
    return true;
});
```

#### `through`

```php
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

$stmt->through(function (SQLiteSelect $stmt) {
    // ...
});
```

### Events

#### `beforeConnect`

`Connection` only.

```php
use MichaelRushton\Database\Events\BeforeConnectEvent;

$connection->beforeConnect(function (BeforeConnectEvent $event)
{
    $event->connection;
    $event->time;
});
```

#### `afterConnect`

`Connection` only.

```php
use MichaelRushton\Database\Events\AfterConnectEvent;

$connection->afterConnect(function (AfterConnectEvent $event)
{
    $event->before_event;
    $event->time;
});
```

#### `beforeBeginTransaction`

`Connection` only.

```php
use MichaelRushton\Database\Events\BeforeBeginTransactionEvent;

$connection->beforeBeginTransaction(function (BeforeBeginTransactionEvent $event)
{
    $event->connection;
    $event->time;
});
```

#### `afterBeginTransaction`

`Connection` only.

```php
use MichaelRushton\Database\Events\AfterBeginTransactionEvent;

$connection->afterBeginTransaction(function (AfterBeginTransactionEvent $event)
{
    $event->before_event;
    $event->success;
    $event->time;
});
```

#### `beforeCommit`

`Connection` only.

```php
use MichaelRushton\Database\Events\BeforeCommitEvent;

$connection->beforeCommit(function (BeforeCommitEvent $event)
{
    $event->connection;
    $event->time;
});
```

#### `afterCommit`

`Connection` only.

```php
use MichaelRushton\Database\Events\AfterCommitEvent;

$connection->afterCommit(function (AfterCommitEvent $event)
{
    $event->before_event;
    $event->success;
    $event->time;
});
```

#### `beforeRollBack`

`Connection` only.

```php
use MichaelRushton\Database\Events\BeforeRollBackEvent;

$connection->beforeRollBack(function (BeforeRollBackEvent $event)
{
    $event->connection;
    $event->exception;
    $event->time;
});
```

#### `afterRollBack`

`Connection` only.

```php
use MichaelRushton\Database\Events\AfterRollBackEvent;

$connection->afterRollBack(function (AfterRollBackEvent $event)
{
    $event->before_event;
    $event->success;
    $event->time;
});
```

#### `beforeClose`

`Connection` only.

```php
use MichaelRushton\Database\Events\BeforeCloseEvent;

$connection->beforeClose(function (BeforeCloseEvent $event)
{
    $event->connection;
    $event->time;
});
```

#### `afterClose`

`Connection` only.

```php
use MichaelRushton\Database\Events\AfterCloseEvent;

$connection->afterClose(function (AfterCloseEvent $event)
{
    $event->before_event;
    $event->time;
});
```

#### `beforeExec`

```php
use MichaelRushton\Database\Events\BeforeExecEvent;

$stmt->beforeExec(function (BeforeExecEvent $event)
{
    $event->connection;
    $event->statement;
    $event->time;
});
```

#### `afterExec`

```php
use MichaelRushton\Database\Events\AfterExecEvent;

$stmt->afterExec(function (AfterExecEvent $event)
{
    $event->before_event;
    $event->count;
    $event->time;
});
```

#### `beforeQuery`

```php
use MichaelRushton\Database\Events\BeforeQueryEvent;

$stmt->beforeQuery(function (BeforeQueryEvent $event)
{
    $event->connection;
    $event->query;
    $event->fetchMode;
    $event->fetchModeArgs;
    $event->time;
});
```

#### `afterQuery`

```php
use MichaelRushton\Database\Events\AfterQueryEvent;

$stmt->afterQuery(function (AfterQueryEvent $event)
{
    $event->before_event;
    $event->statement;
    $event->time;
});
```

#### `beforePrepare`

```php
use MichaelRushton\Database\Events\BeforePrepareEvent;

$stmt->beforePrepare(function (BeforePrepareEvent $event)
{
    $event->connection;
    $event->query;
    $event->options;
    $event->time;
});
```

#### `afterPrepare`

```php
use MichaelRushton\Database\Events\AfterPrepareEvent;

$stmt->afterPrepare(function (AfterPrepareEvent $event)
{
    $event->before_event;
    $event->statement;
    $event->time;
});
```

#### `beforeBindValue`

```php
use MichaelRushton\Database\Events\BeforeBindValueEvent;

$stmt->beforeBindValue(function (BeforeBindValueEvent $event)
{
    $event->connection;
    $event->statement;
    $event->query;
    $event->param;
    $event->value;
    $event->time;
});
```

#### `afterBindValue`

```php
use MichaelRushton\Database\Events\AfterBindValueEvent;

$stmt->afterBindValue(function (AfterBindValueEvent $event)
{
    $event->before_event;
    $event->success;
    $event->time;
});
```

#### `beforeExecute`

```php
use MichaelRushton\Database\Events\BeforeExecuteEvent;

$stmt->beforeExecute(function (BeforeExecuteEvent $event)
{
    $event->connection;
    $event->statement;
    $event->query;
    $event->params;
    $event->time;
});
```

#### `afterExecute`

```php
use MichaelRushton\Database\Events\AfterExecuteEvent;

$stmt->afterExecute(function (AfterExecuteEvent $event)
{
    $event->before_event;
    $event->success;
    $event->time;
});
```

#### `beforeFetch`

```php
use MichaelRushton\Database\Events\BeforeFetchEvent;

$stmt->beforeFetch(function (BeforeFetchEvent $event)
{
    $event->connection;
    $event->statement;
    $event->query;
    $event->params;
    $event->model;
    $event->cursorOrientation;
    $event->cursorOffset;
    $event->time;
});
```

#### `afterFetch`

```php
use MichaelRushton\Database\Events\AfterFetchEvent;

$stmt->afterFetch(function (AfterFetchEvent $event)
{
    $event->before_event;
    $event->row;
    $event->time;
});
```

#### `beforeFetchAll`

```php
use MichaelRushton\Database\Events\BeforeFetchAllEvent;

$stmt->beforeFetchAll(function (BeforeFetchAllEvent $event)
{
    $event->connection;
    $event->statement;
    $event->query;
    $event->params;
    $event->mode;
    $event->args;
    $event->time;
});
```

#### `afterFetchAll`

```php
use MichaelRushton\Database\Events\AfterFetchAllEvent;

$stmt->afterFetchAll(function (AfterFetchAllEvent $event)
{
    $event->before_event;
    $event->rows;
    $event->time;
});
```

#### `beforeFetchColumn`

```php
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;

$stmt->beforeFetchColumn(function (BeforeFetchColumnEvent $event)
{
    $event->connection;
    $event->statement;
    $event->query;
    $event->params;
    $event->column;
    $event->time;
});
```

#### `afterFetchColumn`

```php
use MichaelRushton\Database\Events\AfterFetchColumnEvent;

$stmt->afterFetchColumn(function (AfterFetchColumnEvent $event)
{
    $event->before_event;
    $event->value;
    $event->time;
});
```

#### `beforeFetchObject`

```php
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;

$stmt->beforeFetchObject(function (BeforeFetchObjectEvent $event)
{
    $event->connection;
    $event->statement;
    $event->query;
    $event->params;
    $event->class;
    $event->constructorArgs;
    $event->time;
});
```

#### `afterFetchObject`

```php
use MichaelRushton\Database\Events\AfterFetchObjectEvent;

$stmt->afterFetchObject(function (AfterFetchObjectEvent $event)
{
    $event->before_event;
    $event->object;
    $event->time;
});
```
