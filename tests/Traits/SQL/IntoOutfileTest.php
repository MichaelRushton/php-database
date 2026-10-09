<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Outfile;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;

test('into outfile', function ($path, $expected): void {

    expect(
        (string) new MariaDBSelect()
    ->intoOutfile($path, fn(Outfile $outfile) => $outfile->characterSet('utf8'))
    )
    ->toBe("SELECT * INTO OUTFILE '$expected' CHARACTER SET utf8");

})
->with([
    ['path', 'path'],
    ["'path'", "''path''"],
]);
