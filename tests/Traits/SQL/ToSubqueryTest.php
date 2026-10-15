<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Subquery;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('to subquery', function (): void {

    expect(new SQLiteSelect()->toSubquery())
    ->toBeInstanceOf(Subquery::class);

});
