<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;

test('columns', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteInsert()
        ->columns($column)
    )
    ->toBe("INSERT ($expected) DEFAULT VALUES");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('columns spread', function (): void {

    expect(
        (string) new SQLiteInsert()
        ->columns('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("INSERT (c1, c2, c3, c4) DEFAULT VALUES");

});
