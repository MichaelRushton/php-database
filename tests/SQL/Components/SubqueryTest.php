<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Subquery;

test('subquery', function (): void {

    expect(
        (string) $subquery = new Subquery(new Raw('?', 1))
        ->all()
        ->any()
        ->exists()
        ->in()
        ->lateral()
        ->as('s1')
        ->columns('c1')
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'ALL',
            'ANY',
            'EXISTS',
            'IN',
            'LATERAL',
            '(?)',
            's1',
            '(c1)',
        ])
    );

    expect($subquery->bindings())
    ->toBe([1]);

});
