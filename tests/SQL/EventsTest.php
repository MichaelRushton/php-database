<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
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
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

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
