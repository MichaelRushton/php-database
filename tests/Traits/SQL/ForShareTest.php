<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLSelect;

test('for share', function ($table, $expected): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forShare($table)
    )
    ->toBe("SELECT * FOR SHARE$expected");

})
->with([
    [null, ''],
    ['t1', ' OF t1'],
    [['t1', 't2'], ' OF t1, t2'],
]);

test('for share spread', function (): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forShare('t1', 't2', ['t3', 't4'])
    )
    ->toBe("SELECT * FOR SHARE OF t1, t2, t3, t4");

});

test('for share nowait', function ($table, $expected): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forShareNoWait($table)
    )
    ->toBe("SELECT * FOR SHARE$expected NOWAIT");

})
->with([
    [null, ''],
    ['t1', ' OF t1'],
    [['t1', 't2'], ' OF t1, t2'],
]);

test('for share nowait spread', function (): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forShareNoWait('t1', 't2', ['t3', 't4'])
    )
    ->toBe("SELECT * FOR SHARE OF t1, t2, t3, t4 NOWAIT");

});

test("for share skip locked", function ($table, $expected): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forShareSkipLocked($table)
    )
    ->toBe("SELECT * FOR SHARE$expected SKIP LOCKED");

})
->with([
    [null, ''],
    ['t1', ' OF t1'],
    [['t1', 't2'], ' OF t1, t2'],
]);

test('for share skip locked spread', function (): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forShareSkipLocked('t1', 't2', ['t3', 't4'])
    )
    ->toBe("SELECT * FOR SHARE OF t1, t2, t3, t4 SKIP LOCKED");

});
