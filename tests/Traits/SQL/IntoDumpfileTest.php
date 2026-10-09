<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;

test('into dumpfile', function ($path, $expected): void {

    expect(
        (string) new MariaDBSelect()
        ->intoDumpfile($path)
    )
    ->toBe("SELECT * INTO DUMPFILE '$expected'");

})
->with([
    ['path', 'path'],
    ["'path'", "''path''"],
]);
