<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;

test('sql cache', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->sqlCache()
    )
    ->toBe("SELECT SQL_CACHE *");

});

test('sql no cache', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->sqlNoCache()
    )
    ->toBe("SELECT SQL_NO_CACHE *");

});
