<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\MySQL\MySQLInsert;

test('row alias', function ($expected = '', ...$columns): void {

    expect(
        (string) new MySQLInsert()
      ->as('new', ...$columns)
    )
    ->toBe("INSERT VALUES () AS new$expected");

})
->with([
    [],
    [' (a)', 'a'],
    [' (a, b)', ['a', 'b']],
]);
