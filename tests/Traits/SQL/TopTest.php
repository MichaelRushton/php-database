<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerSelect;

test('top', function ($row_count, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLServerSelect()
        ->top($row_count)
    )
    ->toBe("SELECT TOP ($expected) *");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    [1, '1'],
    [1.1, '1.1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);
