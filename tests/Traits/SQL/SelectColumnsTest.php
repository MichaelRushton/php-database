<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('columns', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->columns($column)
    )
    ->toBe("SELECT $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [null, '?', [null]],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c3' => 'c2'], 'c1, c2 c3'],
]);

test('columns spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->columns('c1', 'c2', ['c3', 'c5' => 'c4'])
    )
    ->toBe("SELECT c1, c2, c3, c4 c5");

});
