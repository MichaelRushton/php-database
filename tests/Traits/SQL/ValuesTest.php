<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBInsert;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLInsert;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLInsert;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerInsert;

test('empty values', function ($stmt, $expected): void {

    expect((string) $stmt->values([]))
    ->toBe("INSERT $expected");

})
->with([
    [new MariaDBInsert(), 'VALUES ()'],
    [new MySQLInsert(), 'VALUES ()'],
    [new PostgreSQLInsert(), 'DEFAULT VALUES'],
    [new SQLiteInsert(), 'DEFAULT VALUES'],
    [new SQLServerInsert(), 'DEFAULT VALUES'],
]);

test('values', function ($values, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteInsert()
        ->values($values)
    )
    ->toBe("INSERT VALUES ($expected)");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    [['test', 1, 1.1, true, null, new Raw('?', 1)], '?, ?, ?, ?, ?, ?', ['test', 1, 1.1, true, null, 1]],
    [[['test'], [1]], '?), (?', ['test', 1]],
]);

test('values with columns', function (): void {

    expect(
        (string) $stmt = new SQLiteInsert()
        ->values([[
            'c1' => 1,
            'c2' => 2,
        ], [
            'c2' => 4,
            'c1' => 3,
        ]])
    )
    ->toBe("INSERT (c1, c2) VALUES (?, ?), (?, ?)");

    expect($stmt->bindings())
    ->toBe([1, 2, 3, 4]);

});
