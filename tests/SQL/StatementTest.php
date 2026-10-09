<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;
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

    $stmt = new SQLiteSelect();

    expect($stmt->beforeExec(fn() => null))
    ->toBe($stmt);

});

test('after exec', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterExec(fn() => null))
    ->toBe($stmt);

});

test('before query', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeQuery(fn() => null))
    ->toBe($stmt);

});

test('after query', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterQuery(fn() => null))
    ->toBe($stmt);

});

test('before prepare', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforePrepare(fn() => null))
    ->toBe($stmt);

});

test('after prepare', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterPrepare(fn() => null))
    ->toBe($stmt);

});

test('before bind value', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeBindValue(fn() => null))
    ->toBe($stmt);

});

test('after bind value', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterBindValue(fn() => null))
    ->toBe($stmt);

});

test('before execute', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeExecute(fn() => null))
    ->toBe($stmt);

});

test('after execute', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterExecute(fn() => null))
    ->toBe($stmt);

});

test('before fetch', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeFetch(fn() => null))
    ->toBe($stmt);

});

test('after fetch', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterFetch(fn() => null))
    ->toBe($stmt);

});

test('before fetch all', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeFetchAll(fn() => null))
    ->toBe($stmt);

});

test('after fetch all', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterFetchAll(fn() => null))
    ->toBe($stmt);

});

test('before fetch column', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeFetchColumn(fn() => null))
    ->toBe($stmt);

});

test('after fetch column', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterFetchColumn(fn() => null))
    ->toBe($stmt);

});

test('before fetch object', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->beforeFetchObject(fn() => null))
    ->toBe($stmt);

});

test('after fetch object', function (): void {

    $stmt = new SQLiteSelect();

    expect($stmt->afterFetchObject(fn() => null))
    ->toBe($stmt);

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

    $stmt->connection()->connect();

    expect($stmt->through(function (SQLiteSelect $c) use ($stmt): void {
        expect($c)
        ->toBe($stmt);

        $stmt->connection()->close();
    }))
    ->toBe($stmt);

    expect($stmt->connection()->pdo())
    ->toBeNull();

});

test('when true', function (): void {

    $stmt = new SQLiteSelect();

    $stmt->connection()->connect();

    expect(
        $stmt->when(
            true,
            if_true: function (SQLiteSelect $c, bool $value) use ($stmt): void {
                expect($c)
                ->toBe($stmt);

                expect($value)
                ->toBeTrue();

                $c->connection()->close();
            },
            if_false: function (): void {
                throw new Exception();
            }
        )
    )
    ->toBe($stmt);

    expect($stmt->connection()->pdo())
    ->toBeNull();

});

test('when false', function (): void {

    $stmt = new SQLiteSelect();

    $stmt->connection()->connect();

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

                $c->connection()->close();
            }
        )
    )
    ->toBe($stmt);

    expect($stmt->connection()->pdo())
    ->toBeNull();

});
