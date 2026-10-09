<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Upsert;

test('upsert', function (): void {

    expect(
        (string) $upsert = new Upsert()
        ->columns('c1')
        ->whereIndex('c1', 1)
        ->onConstraint('c')
        ->set('c1', 1)
        ->where('c1', 1)
        ->when(0)
    )
    ->toBe(implode(' ', [
        '(c1)',
        'WHERE c1 = ?',
        'ON CONSTRAINT c',
        'DO UPDATE',
        'SET c1 = ?',
        'WHERE c1 = ?',
    ]));

    expect($upsert->bindings())
    ->toBe([1, 1, 1]);

});
