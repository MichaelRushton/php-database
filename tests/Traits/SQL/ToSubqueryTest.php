<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Subquery;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('subquery', function (): void {

    expect(new SQLiteSelect()->subquery())
    ->toBeInstanceOf(Subquery::class);

});
