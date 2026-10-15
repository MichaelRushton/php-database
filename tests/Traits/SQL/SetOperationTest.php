<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('union', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->union($stmt)
    )
    ->toBe("SELECT * UNION $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new SQLiteSelect()->columns(1), 'SELECT ?', [1]],
    [fn($stmt) => $stmt->columns(1), 'SELECT ?', [1]],
    [['SELECT 1', 'SELECT 2'], 'SELECT 1 UNION SELECT 2'],
]);

test('union all', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->unionAll($stmt)
    )
    ->toBe("SELECT * UNION ALL $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new SQLiteSelect()->columns(1), 'SELECT ?', [1]],
    [fn($stmt) => $stmt->columns(1), 'SELECT ?', [1]],
    [['SELECT 1', 'SELECT 2'], 'SELECT 1 UNION ALL SELECT 2'],
]);

test('intersect', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->intersect($stmt)
    )
    ->toBe("SELECT * INTERSECT $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new SQLiteSelect()->columns(1), 'SELECT ?', [1]],
    [fn($stmt) => $stmt->columns(1), 'SELECT ?', [1]],
    [['SELECT 1', 'SELECT 2'], 'SELECT 1 INTERSECT SELECT 2'],
]);

test('intersect all', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->intersectAll($stmt)
    )
    ->toBe("SELECT * INTERSECT ALL $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new SQLiteSelect()->columns(1), 'SELECT ?', [1]],
    [fn($stmt) => $stmt->columns(1), 'SELECT ?', [1]],
    [['SELECT 1', 'SELECT 2'], 'SELECT 1 INTERSECT ALL SELECT 2'],
]);

test('except', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->except($stmt)
    )
    ->toBe("SELECT * EXCEPT $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new SQLiteSelect()->columns(1), 'SELECT ?', [1]],
    [fn($stmt) => $stmt->columns(1), 'SELECT ?', [1]],
    [['SELECT 1', 'SELECT 2'], 'SELECT 1 EXCEPT SELECT 2'],
]);

test('except all', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->exceptAll($stmt)
    )
    ->toBe("SELECT * EXCEPT ALL $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new SQLiteSelect()->columns(1), 'SELECT ?', [1]],
    [fn($stmt) => $stmt->columns(1), 'SELECT ?', [1]],
    [['SELECT 1', 'SELECT 2'], 'SELECT 1 EXCEPT ALL SELECT 2'],
]);
