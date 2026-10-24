<?php

declare(strict_types=1);

use MichaelRushton\Database\Configuration;
use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;
use MichaelRushton\Database\Events\AfterBindValueEvent;
use MichaelRushton\Database\Events\AfterExecEvent;
use MichaelRushton\Database\Events\AfterExecuteEvent;
use MichaelRushton\Database\Events\AfterFetchAllEvent;
use MichaelRushton\Database\Events\AfterFetchColumnEvent;
use MichaelRushton\Database\Events\AfterFetchEvent;
use MichaelRushton\Database\Events\AfterFetchObjectEvent;
use MichaelRushton\Database\Events\AfterPrepareEvent;
use MichaelRushton\Database\Events\AfterQueryEvent;
use MichaelRushton\Database\Events\BeforeBindValueEvent;
use MichaelRushton\Database\Events\BeforeExecEvent;
use MichaelRushton\Database\Events\BeforeExecuteEvent;
use MichaelRushton\Database\Events\BeforeFetchAllEvent;
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;
use MichaelRushton\Database\Events\BeforeFetchEvent;
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;
use MichaelRushton\Database\Events\BeforePrepareEvent;
use MichaelRushton\Database\Events\BeforeQueryEvent;
use MichaelRushton\Database\SQL;
use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('exec', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(1)->exec())
    ->toBe(0);

});

test('exec failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->exec())
    ->toBeFalse();

});

test('query', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(['c1' => new Raw('1')])->query())
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('query fetch mode', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(new Raw('1'))->query(PDO::FETCH_NUM))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe([
        0 => 1,
    ]);

});

test('query fetch mode args', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(new Raw('1'))->query(PDO::FETCH_COLUMN, 0))
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe(1);

});

test('query failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->query())
    ->toBeFalse();

});

test('prepare', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(['c1' => '?'])->prepare())
    ->toBeInstanceOf(PDOStatement::class);

    $stmt->execute([1]);

    expect($stmt->fetch())
    ->toBe([
        'c1' => '1',
        0 => '1',
    ]);

});

test('prepare options', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(['c1' => '?'])->prepare([]))
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

    $stmt = new SQLiteSelect($connection);

    expect($stmt->prepare())
    ->toBeFalse();

});

test('cache prepare enabled', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt1 = new SQLiteSelect($connection)->columns(['c1' => 1]);
    $stmt2 = new SQLiteSelect($connection)->columns(['c1' => 1]);
    $stmt3 = new SQLiteSelect($connection)->columns(['c2' => 1]);

    $i = 0;

    foreach ([$stmt1, $stmt2, $stmt3] as $stmt) {

        $stmt->beforePrepare(function () use (&$i): void {
            ++$i;
        });

    }

    expect($stmt = $stmt1->prepare())
    ->toBe($stmt2->prepare());

    expect($i)
    ->toBe(1);

    expect($stmt1->prepare([1]))
    ->not->toBe($stmt);

    expect($stmt3->prepare())
    ->not->toBe($stmt);

    expect($i)
    ->toBe(3);

});

test('cache prepare disabled', function (): void {

    $connection = new SQLiteConnection(
        new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]),
        new Configuration(cache_prepared_statements: false)
    );

    $stmt1 = new SQLiteSelect($connection)->columns(['c1' => 1]);
    $stmt2 = new SQLiteSelect($connection)->columns(['c1' => 1]);
    $stmt3 = new SQLiteSelect($connection)->columns(['c2' => 1]);

    $i = 0;

    foreach ([$stmt1, $stmt2, $stmt3] as $stmt) {

        $stmt->beforePrepare(function () use (&$i): void {
            ++$i;
        });

    }

    expect($stmt1->prepare())
    ->not->toBe($stmt2->prepare());

    $stmt3->prepare();

    expect($i)
    ->toBe(3);

});

test('uncached', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt1 = new SQLiteSelect($connection)->columns(['c1' => 1]);
    $stmt2 = new SQLiteSelect($connection)->columns(['c1' => 1]);
    $stmt3 = new SQLiteSelect($connection)->columns(['c2' => 1]);

    $i = 0;

    foreach ([$stmt1, $stmt2, $stmt3] as $stmt) {

        $stmt->beforePrepare(function () use (&$i): void {
            ++$i;
        });

    }

    expect($stmt = $stmt1->uncached())
    ->toBeInstanceOf(PDOStatement::class)
    ->not->toBe($stmt2->uncached());

    $stmt3->uncached();

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

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(['c1' => SQL::bind($param)])->bindValues())
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

test('bind values resource', function (): void {

    $stmt = new SQLiteSelect();

    $temp = tmpfile();

    fwrite($temp, 'test');

    fseek($temp, 0);

    $stmt = $stmt->columns(['c1' => SQL::bind($temp)])->bindValues();

    $stmt->execute();

    expect($stmt->fetch())
    ->toBe([
        'c1' => 'test',
        0 => 'test',
    ]);

});

test('bind values failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->bindValues())
    ->toBeFalse();

});

test('execute', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt = $stmt->columns(['c1' => 1])->execute())
    ->toBeInstanceOf(PDOStatement::class);

    expect($stmt->fetch())
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('execute failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->execute())
    ->toBeFalse();

});

test('fetch', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->fetch())
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('fetch mode', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->fetch(PDO::FETCH_NUM))
    ->toBe([
        0 => 1,
    ]);

});

test('fetch cursor', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->fetch(cursorOrientation: PDO::FETCH_ORI_NEXT, cursorOffset: 0))
    ->toBe([
        'c1' => 1,
        0 => 1,
    ]);

});

test('fetch failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->fetch())
    ->toBeFalse();

});

test('fetch all', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->unionAll("SELECT 2")->fetchAll())
    ->toBe([[
        'c1' => 1,
        0 => 1,
    ], [
        'c1' => 2,
        0 => 2,
    ]]);

});

test('fetch all mode', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->unionAll("SELECT 2")->fetchAll(PDO::FETCH_NUM))
    ->toBe([[
        0 => 1,
    ], [
        0 => 2,
    ]]);

});

test('fetch all mode args', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->unionAll("SELECT 2")->fetchAll(PDO::FETCH_COLUMN, 0))
    ->toBe([1, 2]);

});

test('fetch all failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->fetchAll())
    ->toBeFalse();

});

test('fetch column', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(1)->fetchColumn())
    ->toBe(1);

});

test('fetch column column', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns([1, 2])->fetchColumn(1))
    ->toBe(2);

});

test('fetch column failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->fetchColumn())
    ->toBeFalse();

});

test('fetch object', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->columns(['c1' => 1])->fetchObject())
    ->toBeInstanceOf(stdClass::class)
    ->toEqual((object) [
        'c1' => 1,
    ]);

});

test('fetch object class', function (): void {

    $stmt = new SQLiteSelect();

    $class = new class {
        protected int $c1 = 1;
    };

    expect($stmt->columns(['c1' => 1])->fetchObject($class::class))
    ->toBeInstanceOf($class::class)
    ->toEqual($class);

});

test('fetch object constructor args', function (): void {

    $stmt = new SQLiteSelect();

    $class = new class {
        public int $c1 = 1;

        public function __construct(
            public int $c2 = 2
        ) {}
    };

    expect($stmt->columns(['c1' => 1])->fetchObject($class::class, constructorArgs: [2]))
    ->toBeInstanceOf($class::class)
    ->toEqual($class);

});

test('fetch object failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->fetchObject())
    ->toBeFalse();

});

test('yield', function (): void {

    $stmt = new SQLiteSelect();

    expect($rows = $stmt->columns(['c1' => 0])->unionAll("SELECT 1")->yield())
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

test('yield mode', function (): void {

    $stmt = new SQLiteSelect();

    $rows = $stmt->columns(['c1' => 0])->unionAll("SELECT 1")->yield(PDO::FETCH_NUM);

    foreach ($rows as $key => $row) {

        expect($row)
        ->toBe([
            0 => $key,
        ]);

    }

});

test('yield cursor', function (): void {

    $stmt = new SQLiteSelect();

    $rows = $stmt->columns(['c1' => 0])->unionAll("SELECT 1")->yield(cursorOrientation: PDO::FETCH_ORI_NEXT, cursorOffset: 0);

    foreach ($rows as $key => $row) {

        expect($row)
        ->toBe([
            'c1' => $key,
            0 => $key,
        ]);

    }

});

test('yield failure', function (): void {

    $connection = new SQLiteConnection(new SQLiteDriver(pdo_options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]));

    $stmt = new SQLiteSelect($connection);

    expect($stmt->yield()->getReturn())
    ->toBeFalse();

});

test('before exec', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeExec(function (BeforeExecEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->statement)
        ->toBe("SELECT ?");

        expect($event->time)
        ->toBeFloat();
    });

    $stmt->columns(1)->exec();

});

test('after exec', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeExec(function (BeforeExecEvent $before_event) use ($stmt): void {

        $stmt->afterExec(function (AfterExecEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(1)->exec();

});

test('before query', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeQuery(function (BeforeQueryEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->query)
        ->toBe("SELECT ?");

        expect($event->fetchMode)
        ->toBe(PDO::FETCH_COLUMN);

        expect($event->fetchModeArgs)
        ->toBe([1]);

        expect($event->time)
        ->toBeFloat();
    });

    $stmt->columns(1)->query(PDO::FETCH_COLUMN, 1);

});

test('after query', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeQuery(function (BeforeQueryEvent $before_event) use ($stmt): void {

        $stmt->afterQuery(function (AfterQueryEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(1)->query();

});

test('before prepare', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforePrepare(function (BeforePrepareEvent $event) use ($connection): void {
        expect($event->connection)
        ->toBe($connection);

        expect($event->query)
        ->toBe("SELECT ?");

        expect($event->options)
        ->toBe([PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        expect($event->time)
        ->toBeFloat();
    });

    $stmt->columns(1)->prepare([PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

});

test('after prepare', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforePrepare(function (BeforePrepareEvent $before_event) use ($stmt): void {

        $stmt->afterPrepare(function (AfterPrepareEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(1)->prepare();

});

test('before execute', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeExecute(function (BeforeExecuteEvent $event) use ($connection): void {
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

    $stmt->columns(1)->execute();

});

test('after execute', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeExecute(function (BeforeExecuteEvent $before_event) use ($stmt): void {

        $stmt->afterExecute(function (AfterExecuteEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->success)
            ->toBeTrue();

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(1)->execute();

});

test('before bind value', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeBindValue(function (BeforeBindValueEvent $event) use ($connection): void {
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

    $stmt->columns(1)->bindValues();

});

test('after bind value', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeBindValue(function (BeforeBindValueEvent $before_event) use ($stmt): void {

        $stmt->afterBindValue(function (AfterBindValueEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->success)
            ->toBeTrue();

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(1)->bindValues();

});

test('before fetch', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetch(function (BeforeFetchEvent $event) use ($connection): void {
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

    $stmt->columns(1)->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_ABS, 1);

});

test('after fetch', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetch(function (BeforeFetchEvent $before_event) use ($stmt): void {

        $stmt->afterFetch(function (AfterFetchEvent $event) use ($before_event): void {
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

    $stmt->columns(['c1' => 1])->fetch();

});

test('before fetch all', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetchAll(function (BeforeFetchAllEvent $event) use ($connection): void {
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

    $stmt->columns(1)->fetchAll(PDO::FETCH_COLUMN, 0);

});

test('after fetch all', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetchAll(function (BeforeFetchAllEvent $before_event) use ($stmt): void {

        $stmt->afterFetchAll(function (AfterFetchAllEvent $event) use ($before_event): void {
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

    $stmt->columns(['c1' => 1])->fetchAll();

});

test('before fetch column', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetchColumn(function (BeforeFetchColumnEvent $event) use ($connection): void {
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

    $stmt->columns([1, 2])->fetchColumn(1);

});

test('after fetch column', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetchColumn(function (BeforeFetchColumnEvent $before_event) use ($stmt): void {

        $stmt->afterFetchColumn(function (AfterFetchColumnEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->value)
            ->toBe(1);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(1)->fetchColumn();

});

test('before fetch object', function (): void {

    $connection = new SQLiteConnection();

    $class = new class {
        public int $c1;

        public function __construct(
            public int $c2 = 2
        ) {}
    };

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetchObject(function (BeforeFetchObjectEvent $event) use ($connection, $class): void {
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

    $stmt->columns(['c1' => 1])->fetchObject($class::class, [2]);

});

test('after fetch object', function (): void {

    $connection = new SQLiteConnection();

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeFetchObject(function (BeforeFetchObjectEvent $before_event) use ($stmt): void {

        $stmt->afterFetchObject(function (AfterFetchObjectEvent $event) use ($before_event): void {
            expect($event->before_event)
            ->toBe($before_event);

            expect($event->object)
            ->toBeInstanceOf(stdClass::class)
            ->toEqual((object) [
                'c1' => 1,
            ]);

            expect($event->time)
            ->toBeFloat();
        });

    });

    $stmt->columns(['c1' => 1])->fetchObject();

});

test('multiple events', function (): void {

    $connection = new SQLiteConnection();

    $i = 0;

    $stmt = new SQLiteSelect($connection);

    $stmt->beforeExec(function () use (&$i): void {
        ++$i;
    });

    $stmt->beforeExec(function () use (&$i): void {
        ++$i;
    });

    $stmt->columns(1)->exec();

    expect($i)
    ->toBe(2);

});

test('pipe', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->pipe(function (SQLiteSelect $c) use ($stmt) {
        expect($c)
        ->toBe($stmt);

        return true;
    }))
    ->toBeTrue();

});

test('through', function (): void {

    $stmt = new SQLiteSelect();

    $stmt->connection->connect();

    expect($stmt->through(function (SQLiteSelect $c) use ($stmt): void {
        expect($c)
        ->toBe($stmt);

        $stmt->connection->close();
    }))
    ->toBe($stmt);

    expect($stmt->connection->pdo)
    ->toBeNull();

});

test('when true', function (): void {

    $stmt = new SQLiteSelect();

    $stmt->connection->connect();

    expect(
        $stmt->when(
            true,
            if_true: function (SQLiteSelect $c, bool $value) use ($stmt): void {
                expect($c)
                ->toBe($stmt);

                expect($value)
                ->toBeTrue();

                $c->connection->close();
            },
            if_false: function (): void {
                throw new Exception();
            }
        )
    )
    ->toBe($stmt);

    expect($stmt->connection->pdo)
    ->toBeNull();

});

test('when false', function (): void {

    $stmt = new SQLiteSelect();

    $stmt->connection->connect();

    expect(
        $stmt->when(
            false,
            if_true: function (): void {
                throw new Exception();
            },
            if_false: function (SQLiteSelect $c, bool $value) use ($stmt): void {
                expect($c)
                ->toBe($stmt);

                expect($value)
                ->toBeFalse();

                $c->connection->close();
            }
        )
    )
    ->toBe($stmt);

    expect($stmt->connection->pdo)
    ->toBeNull();

});
