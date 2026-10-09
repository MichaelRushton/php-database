<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteUpdate;

test('set', function ($column, $value, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteUpdate()
        ->set($column, $value)
    )
    ->toBe("UPDATE SET $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'test', 'c1 = ?', ['test']],
    ['c1', 1, 'c1 = ?', [1]],
    ['c1', 1.1, 'c1 = ?', [1.1]],
    ['c1', true, 'c1 = ?', [true]],
    ['c1', null, 'c1 = ?', [null]],
    ['c1', new Raw('?', 1), 'c1 = ?', [1]],
    [['c1' => 'test', 'c2' => 1], null, 'c1 = ?, c2 = ?', ['test', 1]],
]);
