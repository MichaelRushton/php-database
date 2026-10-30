<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\CTE;

test('search breadth', function ($column, $expected): void {

    expect(
        (string) new CTE('cte', 'SELECT')
        ->searchBreadth($column, 'c0')
    )
    ->toBe("cte AS (SELECT) SEARCH BREADTH FIRST BY $expected SET c0");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('search depth', function ($column, $expected): void {

    expect(
        (string) new CTE('cte', 'SELECT')
        ->searchDepth($column, 'c0')
    )
    ->toBe("cte AS (SELECT) SEARCH DEPTH FIRST BY $expected SET c0");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);
