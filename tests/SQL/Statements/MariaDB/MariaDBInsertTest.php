<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBInsert;

test('extends statement', function (): void {

    expect(new MariaDBInsert())
    ->toBeInstanceOf(Statement::class);

});

test('implements insert interface', function (): void {

    expect(new MariaDBInsert())
    ->toBeInstanceOf(InsertInterface::class);

});

test('implements mariadb insert interface', function (): void {

    expect(new MariaDBInsert())
    ->toBeInstanceOf(MariaDBInsertInterface::class);

});

test('connection', function (): void {

    expect(new MariaDBInsert()->connection())
    ->toBeInstanceOf(MariaDBConnection::class);

});

test('insert', function (): void {

    expect(
        (string) $stmt = new MariaDBInsert()
        ->lowPriority()
        ->delayed()
        ->highPriority()
        ->ignore()
        ->into('t1')
        ->columns('c1')
        ->values([1])
        ->set('c1', 1)
        ->select('SELECT')
        ->onDuplicateKeyUpdate('c1', 1)
        ->returning()
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'INSERT',
            'LOW_PRIORITY',
            'DELAYED',
            'HIGH_PRIORITY',
            'IGNORE',
            'INTO t1',
            '(c1)',
            'VALUES (?)',
            'SET c1 = ?',
            'SELECT',
            'ON DUPLICATE KEY UPDATE c1 = ?',
            'RETURNING *',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1, 1, 1]);

});
