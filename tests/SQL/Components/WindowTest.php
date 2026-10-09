<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Window;

test('window', function (): void {

    expect(
        (string) new Window('w1')
        ->specName('w2')
        ->partitionBy('c1')
        ->orderBy('c1')
        ->range()
        ->when(0)
    )
    ->toBe(implode(' ', [
        'w1',
        'AS',
        '(w2',
        'PARTITION BY c1',
        'ORDER BY c1',
        'RANGE)',
    ]));

});
