<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteUpdate;

test('table', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteUpdate()
        ->table($table)
    )
    ->toBe("UPDATE $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['t1', 't3' => 't2'], 't1, t2 t3'],
]);

test('table spread', function (): void {

    expect(
        (string) new SQLiteUpdate()
        ->table('t1', 't2', ['t3', 't5' => 't4'])
    )
    ->toBe("UPDATE t1, t2, t3, t4 t5");

});
