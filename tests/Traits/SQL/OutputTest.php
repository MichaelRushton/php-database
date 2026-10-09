<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerInsert;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerSelect;

test('output', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLServerInsert()
        ->output($column)
    )
    ->toBe("INSERT OUTPUT $expected DEFAULT VALUES");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [null, '?', [null]],
    [new SQLServerSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c3' => 'c2'], 'c1, c2 c3'],
]);

test('output spread', function (): void {

    expect(
        (string) new SQLServerInsert()
        ->output('c1', 'c2', ['c3', 'c5' => 'c4'])
    )
    ->toBe("INSERT OUTPUT c1, c2, c3, c4 c5 DEFAULT VALUES");

});
