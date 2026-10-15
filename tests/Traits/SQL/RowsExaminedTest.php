<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;

test('rows examined', function ($row_count, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new MariaDBSelect()
        ->rowsExamined($row_count)
    )
    ->toBe("SELECT * LIMIT ROWS EXAMINED $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('rows examined with limit', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->limit(5)
        ->rowsExamined(10)
    )
    ->toBe("SELECT * LIMIT 5 ROWS EXAMINED 10");

});
