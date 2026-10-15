<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;
use MichaelRushton\Database\Events\AfterBeginTransactionEvent;
use MichaelRushton\Database\Events\AfterBindValueEvent;
use MichaelRushton\Database\Events\AfterCloseEvent;
use MichaelRushton\Database\Events\AfterCommitEvent;
use MichaelRushton\Database\Events\AfterConnectEvent;
use MichaelRushton\Database\Events\AfterExecEvent;
use MichaelRushton\Database\Events\AfterExecuteEvent;
use MichaelRushton\Database\Events\AfterFetchAllEvent;
use MichaelRushton\Database\Events\AfterFetchColumnEvent;
use MichaelRushton\Database\Events\AfterFetchEvent;
use MichaelRushton\Database\Events\AfterFetchObjectEvent;
use MichaelRushton\Database\Events\AfterPrepareEvent;
use MichaelRushton\Database\Events\AfterQueryEvent;
use MichaelRushton\Database\Events\AfterRollBackEvent;
use MichaelRushton\Database\Events\BeforeBeginTransactionEvent;
use MichaelRushton\Database\Events\BeforeBindValueEvent;
use MichaelRushton\Database\Events\BeforeCloseEvent;
use MichaelRushton\Database\Events\BeforeCommitEvent;
use MichaelRushton\Database\Events\BeforeConnectEvent;
use MichaelRushton\Database\Events\BeforeExecEvent;
use MichaelRushton\Database\Events\BeforeExecuteEvent;
use MichaelRushton\Database\Events\BeforeFetchAllEvent;
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;
use MichaelRushton\Database\Events\BeforeFetchEvent;
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;
use MichaelRushton\Database\Events\BeforePrepareEvent;
use MichaelRushton\Database\Events\BeforeQueryEvent;
use MichaelRushton\Database\Events\BeforeRollBackEvent;
use MichaelRushton\Database\Settings\ConnectionSettings;

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

test('cache prepare enabled', function (): void {

    $connection = new SQLiteConnection();

    $i = 0;

    $connection->beforePrepare(function () use (&$i): void {
        ++$i;
    });

    expect($stmt = $connection->prepare("SELECT ? c1"))
    ->toBe($connection->prepare("SELECT ? c1"));

    expect($i)
    ->toBe(1);

    expect($connection->prepare("SELECT ? c2"))
    ->not->toBe($stmt);

    expect($i)
    ->toBe(2);

});

test('cache prepare disabled', function (): void {

    $connection = new SQLiteConnection(settings: new ConnectionSettings(cache_prepared_statements: false));

    $i = 0;

    $connection->beforePrepare(function () use (&$i): void {
        ++$i;
    });

    expect($connection->prepare("SELECT ? c1"))
    ->not->toBe($connection->prepare("SELECT ? c1"));

    $connection->prepare("SELECT ? c2");

    expect($i)
    ->toBe(3);

});

test('uncached', function (): void {

    $connection = new SQLiteConnection();

    $i = 0;

    $connection->beforePrepare(function () use (&$i): void {
        ++$i;
    });

    expect($stmt = $connection->uncached("SELECT ? c1"))
    ->toBeInstanceOf(PDOStatement::class)
    ->not->toBe($connection->uncached("SELECT ? c1"));

    $connection->uncached("SELECT ? c2");

    expect($i)
    ->toBe(3);

    $stmt->execute([1]);

    expect($stmt->fetch())
    ->toBe([
        'c1' => '1',
        0 => '1',
    ]);

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

    $i = 0;

    $connection->beforePrepare(function () use (&$i): void {
        ++$i;
    });

    $connection->prepare("SELECT ? c1");

    expect($connection->connect()->close())
    ->toBe($connection);

    expect($connection->pdo())
    ->toBeNull();

    $connection->prepare("SELECT ? c1");

    expect($i)
    ->toBe(2);

});

test('before connect', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeConnect(function (BeforeConnectEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->connect();

});

test('after connect', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeConnect(function (BeforeConnectEvent $before_event) use ($connection): void {

        $connection->afterConnect(function (AfterConnectEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->connect();

});

test('before exec', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeExec(function (BeforeExecEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBe("SELECT 1");

        expect($event->time)
        ->toBeFloat();
    });

    $connection->exec("SELECT 1");

});

test('after exec', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeExec(function (BeforeExecEvent $before_event) use ($connection): void {

        $connection->afterExec(function (AfterExecEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->exec("SELECT 1");

});

test('before query', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeQuery(function (BeforeQueryEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->query)
        ->toBe("SELECT 1");

        expect($event->fetchMode)
        ->toBe(PDO::FETCH_COLUMN);

        expect($event->fetchModeArgs)
        ->toBe([1]);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->query("SELECT 1", PDO::FETCH_COLUMN, 1);

});

test('after query', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeQuery(function (BeforeQueryEvent $before_event) use ($connection): void {

        $connection->afterQuery(function (AfterQueryEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->query("SELECT 1");

});

test('before prepare', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforePrepare(function (BeforePrepareEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->query)
        ->toBe("SELECT 1");

        expect($event->options)
        ->toBe([PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->prepare("SELECT 1", [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

});

test('after prepare', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforePrepare(function (BeforePrepareEvent $before_event) use ($connection): void {

        $connection->afterPrepare(function (AfterPrepareEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->prepare("SELECT 1");

});

test('before execute', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeExecute(function (BeforeExecuteEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBeInstanceOf(PDOStatement::class);

        expect($event->query)
        ->toBe("SELECT ?");

        expect($event->params)
        ->toBe([1]);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->execute("SELECT ?", [1]);

});

test('after execute', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeExecute(function (BeforeExecuteEvent $before_event) use ($connection): void {

        $connection->afterExecute(function (AfterExecuteEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->success)
            ->toBeTrue();

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->execute("SELECT 1");

});

test('before bind value', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeBindValue(function (BeforeBindValueEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBeInstanceOf(PDOStatement::class);

        expect($event->query)
        ->toBe("SELECT ?");

        expect($event->param)
        ->toBe(0);

        expect($event->value)
        ->toBe(1);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->bindValues("SELECT ?", [1]);

});

test('after bind value', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeBindValue(function (BeforeBindValueEvent $before_event) use ($connection): void {

        $connection->afterBindValue(function (AfterBindValueEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->success)
            ->toBeTrue();

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->bindValues("SELECT ?", [1]);

});

test('before fetch', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetch(function (BeforeFetchEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBeInstanceOf(PDOStatement::class);

        expect($event->query)
        ->toBe("SELECT ?");

        expect($event->params)
        ->toBe([1]);

        expect($event->mode)
        ->toBe(PDO::FETCH_NUM);

        expect($event->cursorOrientation)
        ->toBe(PDO::FETCH_ORI_ABS);

        expect($event->cursorOffset)
        ->toBe(1);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->fetch("SELECT ?", [1], PDO::FETCH_NUM, PDO::FETCH_ORI_ABS, 1);

});

test('after fetch', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetch(function (BeforeFetchEvent $before_event) use ($connection): void {

        $connection->afterFetch(function (AfterFetchEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->row)
            ->toBe([
                'c1' => 1,
                0 => 1,
            ]);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->fetch("SELECT 1 c1");

});

test('before fetch all', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetchAll(function (BeforeFetchAllEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBeInstanceOf(PDOStatement::class);

        expect($event->query)
        ->toBe("SELECT ?");

        expect($event->params)
        ->toBe([1]);

        expect($event->mode)
        ->toBe(PDO::FETCH_COLUMN);

        expect($event->args)
        ->toBe([0]);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->fetchAll("SELECT ?", [1], PDO::FETCH_COLUMN, 0);

});

test('after fetch all', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetchAll(function (BeforeFetchAllEvent $before_event) use ($connection): void {

        $connection->afterFetchAll(function (AfterFetchAllEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->rows)
            ->toBe([[
                'c1' => 1,
                0 => 1,
            ]]);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->fetchAll("SELECT 1 c1");

});

test('before fetch column', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetchColumn(function (BeforeFetchColumnEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBeInstanceOf(PDOStatement::class);

        expect($event->query)
        ->toBe("SELECT ?, ?");

        expect($event->params)
        ->toBe([1, 2]);

        expect($event->column)
        ->toBe(1);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->fetchColumn("SELECT ?, ?", [1, 2], 1);

});

test('after fetch column', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetchColumn(function (BeforeFetchColumnEvent $before_event) use ($connection): void {

        $connection->afterFetchColumn(function (AfterFetchColumnEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->value)
            ->toBe(1);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->fetchColumn("SELECT 1");

});

test('before fetch object', function (): void {

    $connection = new SQLiteConnection();

    $class = new class {
        public int $c1;

        public function __construct(
            public int $c2 = 2
        ) {}
    };

    $connection->beforeFetchObject(function (BeforeFetchObjectEvent $event) use ($connection, $class): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBeInstanceOf(PDOStatement::class);

        expect($event->query)
        ->toBe("SELECT ? c1");

        expect($event->params)
        ->toBe([1]);

        expect($event->class)
        ->toBe($class::class);

        expect($event->constructorArgs)
        ->toBe([2]);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->fetchObject("SELECT ? c1", [1], $class::class, [2]);

});

test('after fetch object', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeFetchObject(function (BeforeFetchObjectEvent $before_event) use ($connection): void {

        $connection->afterFetchObject(function (AfterFetchObjectEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->object)
            ->toBeInstanceOf(stdClass::class)
            ->toEqual((object) [
                1 => 1,
            ]);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->fetchObject("SELECT 1");

});

test('before begin transaction', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeBeginTransaction(function (BeforeBeginTransactionEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->transaction(fn() => null);

});

test('after begin transaction', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeBeginTransaction(function (BeforeBeginTransactionEvent $before_event) use ($connection): void {

        $connection->afterBeginTransaction(function (AfterBeginTransactionEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->transaction(fn() => null);

});

test('before commit', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeCommit(function (BeforeCommitEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->transaction(fn() => null);

});

test('after commit', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeCommit(function (BeforeCommitEvent $before_event) use ($connection): void {

        $connection->afterCommit(function (AfterCommitEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->success)
            ->toBeTrue();

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->transaction(fn() => null);

});

test('before roll back', function (): void {

    $connection = new SQLiteConnection();

    $exception = new Exception();

    $connection->beforeRollBack(function (BeforeRollBackEvent $event) use ($connection, $exception): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->exception)
        ->toBe($exception);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->transaction(fn() => throw $exception);

})
->throws(Exception::class);

test('after roll back', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeRollBack(function (BeforeRollBackEvent $before_event) use ($connection): void {

        $connection->afterRollBack(function (AfterRollBackEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->transaction(fn() => throw new Exception());

})
->throws(Exception::class);

test('before close', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeClose(function (BeforeCloseEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->time)
        ->toBeFloat();
    });

    $connection->connect()->close();

});

test('after close', function (): void {

    $connection = new SQLiteConnection();

    $connection->beforeClose(function (BeforeCloseEvent $before_event) use ($connection): void {

        $connection->afterClose(function (AfterCloseEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $connection->connect()->close();

});

test('multiple events', function (): void {

    $connection = new SQLiteConnection();

    $i = 0;

    $connection->beforeConnect(function () use (&$i): void {
        ++$i;
    });

    $connection->beforeConnect(function () use (&$i): void {
        ++$i;
    });

    $connection->connect();

    expect($i)
    ->toBe(2);

});

test('close on destruct', function (): void {

    $connection = new SQLiteConnection();

    $i = 0;

    $connection->beforeClose(function () use (&$i): void {
        ++$i;
    });

    $connection->afterClose(function () use (&$i): void {
        ++$i;
    });

    $connection->connect();

    unset($connection);

    expect($i)
    ->toBe(2);

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
