<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('limit', function ($row_count, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->limit($row_count)
    )
    ->toBe("SELECT * LIMIT $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('limit offset', function ($offset, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->limit(1, $offset)
    )
    ->toBe("SELECT * LIMIT 1 OFFSET $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);
