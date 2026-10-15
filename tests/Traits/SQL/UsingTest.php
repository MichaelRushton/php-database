<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLDelete;

test('using', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new PostgreSQLDelete()
        ->using($table)
    )
    ->toBe("DELETE USING $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 1), '?', [1]],
    [['t1', 't3' => 't2'], 't1, t2 t3'],
]);

test('using spread', function (): void {

    expect(
        (string) new PostgreSQLDelete()
        ->using('t1', 't2', ['t3', 't5' => 't4'])
    )
    ->toBe("DELETE USING t1, t2, t3, t4 t5");

});
