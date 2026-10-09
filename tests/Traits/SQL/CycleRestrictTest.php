<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\CTE;

test('cycle restrict', function ($column, $expected): void {

    expect(
        (string) new CTE('cte', 'SELECT')
        ->cycleRestrict($column)
    )
    ->toBe("cte AS (SELECT) CYCLE $expected RESTRICT");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('cycle restrict spread', function (): void {

    expect(
        (string) new CTE('cte', 'SELECT')
        ->cycleRestrict('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("cte AS (SELECT) CYCLE c1, c2, c3, c4 RESTRICT");

});
