<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\CTE;
use MichaelRushton\Database\SQL\Components\Raw;

test('cte', function (): void {

    expect(
        (string) $cte = new CTE('cte1', new Raw('SELECT ?', 1))
        ->columns('c1')
        ->materialized()
        ->cycleRestrict('c1')
        ->searchBreadth('c1', 'c2')
        ->cycle('c1')
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'cte1',
            '(c1)',
            'AS',
            'MATERIALIZED',
            '(SELECT ?)',
            'CYCLE c1 RESTRICT',
            'SEARCH BREADTH FIRST BY c1 SET c2',
            'CYCLE c1 SET is_cycle USING path',
        ])
    );

    expect($cte->bindings())
    ->toBe([1]);

});
