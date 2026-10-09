<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;

test('or fail', function (): void {

    expect(
        (string) new SQLiteInsert()
        ->orFail()
    )
    ->toBe("INSERT OR FAIL DEFAULT VALUES");

});

test('or ignore', function (): void {

    expect(
        (string) new SQLiteInsert()
        ->orIgnore()
    )
    ->toBe("INSERT OR IGNORE DEFAULT VALUES");

});

test('or replace', function (): void {

    expect(
        (string) new SQLiteInsert()
        ->orReplace()
    )
    ->toBe("INSERT OR REPLACE DEFAULT VALUES");

});

test('or roll back', function (): void {

    expect(
        (string) new SQLiteInsert()
        ->orRollBack()
    )
    ->toBe("INSERT OR ROLLBACK DEFAULT VALUES");

});
