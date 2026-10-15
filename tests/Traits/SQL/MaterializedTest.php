<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\CTE;

test('materialized', function (): void {

    expect(
        (string) new CTE('cte', 'SELECT')
        ->materialized()
    )
    ->toBe("cte AS MATERIALIZED (SELECT)");

});

test('not materialized', function (): void {

    expect(
        (string) new CTE('cte', 'SELECT')
        ->notMaterialized()
    )
    ->toBe("cte AS NOT MATERIALIZED (SELECT)");

});
