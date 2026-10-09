<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLInsert;

test('overriding system value', function (): void {

    expect(
        (string) new PostgreSQLInsert()
        ->overridingSystemValue()
    )
    ->toBe("INSERT OVERRIDING SYSTEM VALUE DEFAULT VALUES");

});

test('overriding user value', function (): void {

    expect(
        (string) new PostgreSQLInsert()
        ->overridingUserValue()
    )
    ->toBe("INSERT OVERRIDING USER VALUE DEFAULT VALUES");

});
