<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('select', function ($stmt, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteInsert()
        ->select($stmt)
    )
    ->toBe("INSERT $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['SELECT', 'SELECT'],
    [new Raw('SELECT ?', [1]), 'SELECT ?', [1]],
    [fn(SQLiteSelect $stmt) => $stmt->columns(1), 'SELECT ?', [1]],
]);
