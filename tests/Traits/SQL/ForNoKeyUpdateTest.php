<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLSelect;

test('for no key update', function ($table, $expected): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forNoKeyUpdate($table)
    )
    ->toBe("SELECT * FOR NO KEY UPDATE$expected");

})
->with([
    [null, ''],
    ['t1', ' OF t1'],
    [['t1', 't2'], ' OF t1, t2'],
]);

test('for no key update spread', function (): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forNoKeyUpdate('t1', 't2', ['t3', 't4'])
    )
    ->toBe("SELECT * FOR NO KEY UPDATE OF t1, t2, t3, t4");

});

test('for no key update nowait', function ($table, $expected): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forNoKeyUpdateNoWait($table)
    )
    ->toBe("SELECT * FOR NO KEY UPDATE$expected NOWAIT");

})
->with([
    [null, ''],
    ['t1', ' OF t1'],
    [['t1', 't2'], ' OF t1, t2'],
]);

test('for no key update nowait spread', function (): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forNoKeyUpdateNoWait('t1', 't2', ['t3', 't4'])
    )
    ->toBe("SELECT * FOR NO KEY UPDATE OF t1, t2, t3, t4 NOWAIT");

});

test("for no key update skip locked", function ($table, $expected): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forNoKeyUpdateSkipLocked($table)
    )
    ->toBe("SELECT * FOR NO KEY UPDATE$expected SKIP LOCKED");

})
->with([
    [null, ''],
    ['t1', ' OF t1'],
    [['t1', 't2'], ' OF t1, t2'],
]);

test('for no key update skip locked spread', function (): void {

    expect(
        (string) new PostgreSQLSelect()
        ->forNoKeyUpdateSkipLocked('t1', 't2', ['t3', 't4'])
    )
    ->toBe("SELECT * FOR NO KEY UPDATE OF t1, t2, t3, t4 SKIP LOCKED");

});
