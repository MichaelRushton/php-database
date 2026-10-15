<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Window;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('windows', function (): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->window('w1', fn(Window $window) => $window->orderBy(new Raw('?', 1)))
    )
    ->toBe("SELECT * WINDOW w1 AS (ORDER BY ?)");

    expect($stmt->bindings())
    ->toBe([1]);

});

test('multiple windows', function (): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->window('w1', fn(Window $window) => $window->orderBy(new Raw('?', 1)))
        ->window('w2', fn(Window $window) => $window->orderBy(new Raw('?', 2)))
    )
    ->toBe("SELECT * WINDOW w1 AS (ORDER BY ?), w2 AS (ORDER BY ?)");

    expect($stmt->bindings())
    ->toBe([1, 2]);

});
