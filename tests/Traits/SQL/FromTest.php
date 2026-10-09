<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('from', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->from($table)
    )
    ->toBe("SELECT * FROM $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['t1', 't3' => 't2'], 't1, t2 t3'],
]);

test('from spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->from('t1', 't2', ['t3', 't5' => 't4'])
    )
    ->toBe("SELECT * FROM t1, t2, t3, t4 t5");

});
