<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;

test('into var', function ($var, $expected): void {

    expect(
        (string) new MariaDBSelect()
        ->intoVar($var)
    )
    ->toBe("SELECT * INTO $expected");

})
->with([
    ['v1', '@v1'],
    [['v1', 'v2'], '@v1, @v2'],
]);

test('into var spread', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->intoVar('v1', 'v2', ['v3', 'v4'])
    )
    ->toBe("SELECT * INTO @v1, @v2, @v3, @v4");

});
