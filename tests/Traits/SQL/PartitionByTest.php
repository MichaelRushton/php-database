<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Window;

test('partition', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->partitionBy($column)
    )
    ->toBe("w1 AS (PARTITION BY $expected)");

    expect($window->bindings())
    ->toBe($bindings);

})
->with([
    ['p1', 'p1'],
    [new Raw('?', 1), '?', [1]],
    [['p1', 'p2'], 'p1, p2'],
]);

test('partition spread', function (): void {

    expect(
        (string) new Window('w1')
        ->partitionBy('p1', 'p2', ['p3', 'p4'])
    )
    ->toBe("w1 AS (PARTITION BY p1, p2, p3, p4)");

});
