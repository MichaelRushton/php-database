<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;

test('driver', function (): void {

    $connection = new SQLiteConnection($driver = new SQLiteDriver());

    expect($connection->driver())
    ->toBeInstanceOf(SQLiteDriver::class)
    ->toBe($driver);

});

test('connect and pdo', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->pdo())
    ->toBeNull();

    expect($connection->connect())
    ->toBe($connection);

    expect($connection->pdo())
    ->toBeInstanceOf(Pdo\Sqlite::class)
    ->toBe($connection->pdo());

});

test('exec', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->exec("SELECT 1"))
    ->toBe(0);

});

test('exec failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->exec("SELECT"))
    ->toBeFalse();

});

test('query', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->query("SELECT 1 c1"))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('query fetch mode', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->query("SELECT 1", PDO::FETCH_NUM))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe([
        0 => 1,
    ]);

});

test('query fetch mode args', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->query("SELECT 1", PDO::FETCH_COLUMN, 0))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe(1);

});

test('query failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->query("SELECT"))
    ->toBeFalse();

});

test('prepare', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->prepare("SELECT ? c1"))
    ->toBeInstanceOf(PDOStatement::class);

    $stmt->execute([1]);

    expect($stmt->fetch())
    ->toBe([
        'c1' => '1',
        0 => '1',
    ]);

});

test('prepare options', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->prepare("SELECT ? c1", []))
    ->toBeInstanceOf(PDOStatement::class);

    $stmt->execute([1]);

    expect($stmt->fetch())
    ->toBe([
        'c1' => '1',
        0 => '1',
    ]);

});

test('prepare failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->prepare("SELECT"))
    ->toBeFalse();

});

test('bind values', function ($param, $expected): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->bindValues("SELECT ? c1", [$param]))
    ->toBeInstanceOf(PDOStatement::class);

    $stmt->execute();

    expect($stmt->fetch())
    ->toBe([
        'c1' => $expected,
        0 => $expected,
    ]);

})
->with([
    ['c1', 'c1'],
    [1, 1],
    [1.1, '1.1'],
    [true, 1],
    [null, null],
]);

test('bind values failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->bindValues("SELECT"))
    ->toBeFalse();

});

test('execute', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->execute("SELECT 1 c1"))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('execute params', function ($param, $expected): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->execute("SELECT ?", [$param]))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch(PDO::FETCH_COLUMN))
    ->toBe($expected);

})
->with([
    ['c1', 'c1'],
    [1, 1],
    [1.1, '1.1'],
    [true, 1],
    [null, null],
]);

test('execute failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->execute("SELECT"))
    ->toBeFalse();

});

test('fetch', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetch("SELECT 1 c1"))
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('fetch params', function ($param, $expected): void {

    $connection = new SQLiteConnection();

    expect($connection->fetch("SELECT ? c1", [$param]))
    ->toBe([
        'c1' => $expected,
        0 => $expected,
    ]);

})
->with([
    ['c1', 'c1'],
    [1, 1],
    [1.1, '1.1'],
    [true, 1],
    [null, null],
]);

test('fetch mode', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetch("SELECT 1", mode: PDO::FETCH_NUM))
    ->toBe([
        0 => 1,
    ]);

});

test('fetch cursor', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetch("SELECT 1 c1", cursorOrientation: PDO::FETCH_ORI_NEXT, cursorOffset: 0))
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('fetch failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->fetch("SELECT"))
    ->toBeFalse();

});

test('fetch all', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchAll("SELECT 1 c1 UNION SELECT 2"))
    ->toBe([[
        'c1' => 1,
        0 => 1,
    ], [
        'c1' => 2,
        0 => 2,
    ]]);

});

test('fetch all params', function ($param, $expected): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchAll("SELECT ? c1 UNION ALL SELECT ?", [$param, $param]))
    ->toBe([[
        'c1' => $expected,
        0 => $expected,
    ], [
        'c1' => $expected,
        0 => $expected,
    ]]);

})
->with([
    ['c1', 'c1'],
    [1, 1],
    [1.1, '1.1'],
    [true, 1],
    [null, null],
]);

test('fetch all mode', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchAll("SELECT 1 UNION SELECT 2", mode: PDO::FETCH_NUM))
    ->toBe([[
        0 => 1,
    ], [
        0 => 2,
    ]]);

});

test('fetch all mode args', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchAll("SELECT 1 UNION SELECT 2", [], PDO::FETCH_COLUMN, 0))
    ->toBe([1, 2]);

});

test('fetch all failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->fetchAll("SELECT"))
    ->toBeFalse();

});

test('fetch column', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchColumn("SELECT 1"))
    ->toBe(1);

});

test('fetch column params', function ($param, $expected): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchColumn("SELECT ?", [$param]))
    ->toBe($expected);

})
->with([
    ['c1', 'c1'],
    [1, 1],
    [1.1, '1.1'],
    [true, 1],
    [null, null],
]);

test('fetch column column', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchColumn("SELECT 1, 2", column: 1))
    ->toBe(2);

});

test('fetch column failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->fetchColumn("SELECT"))
    ->toBeFalse();

});

test('fetch object', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchObject("SELECT 1 c1"))
    ->toBeInstanceOf(stdClass::class)
    ->toEqual((object) [
        'c1' => 1,
    ]);

});

test('fetch object params', function ($param, $expected): void {

    $connection = new SQLiteConnection();

    expect($connection->fetchObject("SELECT ? c1", [$param]))
    ->toBeInstanceOf(stdClass::class)
    ->toEqual((object) [
        'c1' => $expected,
    ]);

})
->with([
    ['c1', 'c1'],
    [1, 1],
    [1.1, '1.1'],
    [true, 1],
    [null, null],
]);

test('fetch object class', function (): void {

    $connection = new SQLiteConnection();

    $class = new class {
        protected int $c1 = 1;
    };

    expect($connection->fetchObject("SELECT 1 c1", class: $class::class))
    ->toBeInstanceOf($class::class)
    ->toEqual($class);

});

test('fetch object constructor args', function (): void {

    $connection = new SQLiteConnection();

    $class = new class {
        public int $c1 = 1;

        public function __construct(
            public int $c2 = 2
        ) {}
    };

    expect($connection->fetchObject("SELECT 1 c1", class: $class::class, constructorArgs: [2]))
    ->toBeInstanceOf($class::class)
    ->toEqual($class);

});

test('fetch object failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->fetchObject("SELECT"))
    ->toBeFalse();

});

test('yield', function (): void {

    $connection = new SQLiteConnection();

    expect($rows = $connection->yield("SELECT 0 c1 UNION SELECT 1"))
    ->toBeInstanceOf(Generator::class);

    foreach ($rows as $key => $row) {

        expect($row)
        ->toBe([
            'c1' => $key,
            0 => $key,
        ]);

    }

    expect($key)
    ->toBe(1);

});

test('yield params', function (): void {

    $connection = new SQLiteConnection();

    $rows = $connection->yield("SELECT ? c1 UNION SELECT ?", [0, 1]);

    foreach ($rows as $key => $row) {

        expect($row)
        ->toBe([
            'c1' => $key,
            0 => $key,
        ]);

    }

});

test('yield mode', function (): void {

    $connection = new SQLiteConnection();

    $rows = $connection->yield("SELECT 0 UNION SELECT 1", mode: PDO::FETCH_NUM);

    foreach ($rows as $key => $row) {

        expect($row)
        ->toBe([
            0 => $key,
        ]);

    }

});

test('yield cursor', function (): void {

    $connection = new SQLiteConnection();

    $rows = $connection->yield("SELECT 0 UNION SELECT 1", cursorOrientation: PDO::FETCH_ORI_NEXT, cursorOffset: 0);

    foreach ($rows as $key => $row) {

        expect($row)
        ->toBe([
            0 => $key,
        ]);

    }

});

test('yield failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    expect($connection->yield("SELECT")->getReturn())
    ->toBeFalse();

});

test('transaction', function (): void {

    $connection = new SQLiteConnection();

    $pdo = $connection->connect()->pdo();

    $pdo->query("CREATE TABLE users (id)");

    expect($connection->transaction(function (SQLiteConnection $c) use ($connection): void {

        expect($c)
        ->toBe($connection);

        expect($c->pdo()->inTransaction())
        ->toBeTrue();

        $c->pdo()->query("INSERT INTO users VALUES (1)");

    }))
    ->toBeTrue();

    expect($connection->pdo()->inTransaction())
    ->toBeFalse();

    expect($pdo->query("SELECT id FROM users")->fetch())
    ->toBe([
        'id' => 1,
        0 => 1,
    ]);

});

test('transaction rolls back', function (): void {

    $connection = new SQLiteConnection();

    $pdo = $connection->connect()->pdo();

    $pdo->query("CREATE TABLE users (id)");

    try {

        $connection->transaction(function (SQLiteConnection $c): void {

            $c->pdo()->query("INSERT INTO users VALUES (1)");

            throw new Exception();

        });

    } finally {

        expect($connection->pdo()->inTransaction())
        ->toBeFalse();

        expect($pdo->query("SELECT id FROM users")->fetch())
        ->toBeFalse();

    }

})
->throws(Exception::class);

test('close', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->connect()->close())
    ->toBe($connection);

    expect($connection->pdo())
    ->toBeNull();

});

test('before connect', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeConnect(fn() => null))
    ->toBe($connection);

});

test('after connect', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterConnect(fn() => null))
    ->toBe($connection);

});

test('before exec', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeExec(fn() => null))
    ->toBe($connection);

});

test('after exec', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterExec(fn() => null))
    ->toBe($connection);

});

test('before query', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeQuery(fn() => null))
    ->toBe($connection);

});

test('after query', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterQuery(fn() => null))
    ->toBe($connection);

});

test('before prepare', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforePrepare(fn() => null))
    ->toBe($connection);

});

test('after prepare', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterPrepare(fn() => null))
    ->toBe($connection);

});

test('before bind value', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeBindValue(fn() => null))
    ->toBe($connection);

});

test('after bind value', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterBindValue(fn() => null))
    ->toBe($connection);

});

test('before execute', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeExecute(fn() => null))
    ->toBe($connection);

});

test('after execute', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterExecute(fn() => null))
    ->toBe($connection);

});

test('before fetch', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeFetch(fn() => null))
    ->toBe($connection);

});

test('after fetch', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterFetch(fn() => null))
    ->toBe($connection);

});

test('before fetch all', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeFetchAll(fn() => null))
    ->toBe($connection);

});

test('after fetch all', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterFetchAll(fn() => null))
    ->toBe($connection);

});

test('before fetch column', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeFetchColumn(fn() => null))
    ->toBe($connection);

});

test('after fetch column', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterFetchColumn(fn() => null))
    ->toBe($connection);

});

test('before fetch object', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeFetchObject(fn() => null))
    ->toBe($connection);

});

test('after fetch object', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterFetchObject(fn() => null))
    ->toBe($connection);

});

test('before begin transaction', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeBeginTransaction(fn() => null))
    ->toBe($connection);

});

test('after begin transaction', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterBeginTransaction(fn() => null))
    ->toBe($connection);

});

test('before commit', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeCommit(fn() => null))
    ->toBe($connection);

});

test('after commit', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterCommit(fn() => null))
    ->toBe($connection);

});

test('before roll back', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeRollBack(fn() => null))
    ->toBe($connection);

});

test('after roll back', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterRollBack(fn() => null))
    ->toBe($connection);

});

test('before close', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->beforeClose(fn() => null))
    ->toBe($connection);

});

test('after close', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->afterClose(fn() => null))
    ->toBe($connection);

});

test('pipe', function (): void {

    $connection = new SQLiteConnection();

    expect($connection->pipe(function (SQLiteConnection $c) use ($connection) {
        expect($c)
        ->toBe($connection);

        return true;
    }))
    ->toBeTrue();

});

test('through', function (): void {

    $connection = new SQLiteConnection();

    $connection->connect();

    expect($connection->through(function (SQLiteConnection $c) use ($connection): void {
        expect($c)
        ->toBe($connection);

        $connection->close();
    }))
    ->toBe($connection);

    expect($connection->pdo())
    ->toBeNull();

});

test('when true', function (): void {

    $connection = new SQLiteConnection();

    $connection->connect();

    expect(
        $connection->when(
            true,
            if_true: function (SQLiteConnection $c, bool $value) use ($connection): void {
                expect($c)
                ->toBe($connection);

                expect($value)
                ->toBeTrue();

                $c->close();
            },
            if_false: function (): void {
                throw new Exception();
            }
        )
    )
    ->toBe($connection);

    expect($connection->pdo())
    ->toBeNull();

});

test('when false', function (): void {

    $connection = new SQLiteConnection();

    $connection->connect();

    expect(
        $connection->when(
            false,
            if_true: function (): void {
                throw new Exception();
            },
            if_false: function (SQLiteConnection $c, bool $value) use ($connection): void {
                expect($c)
                ->toBe($connection);

                expect($value)
                ->toBeFalse();

                $c->close();
            }
        )
    )
    ->toBe($connection);

    expect($connection->pdo())
    ->toBeNull();

});
