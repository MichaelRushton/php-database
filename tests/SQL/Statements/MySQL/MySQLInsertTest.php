<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLInsert;

test('extends statement', function (): void {

    expect(new MySQLInsert())
    ->toBeInstanceOf(Statement::class);

});

test('implements insert interface', function (): void {

    expect(new MySQLInsert())
    ->toBeInstanceOf(InsertInterface::class);

});

test('implements mysql insert interface', function (): void {

    expect(new MySQLInsert())
    ->toBeInstanceOf(MySQLInsertInterface::class);

});

test('connection', function (): void {

    expect(new MySQLInsert()->connection())
    ->toBeInstanceOf(MySQLConnection::class);

});

test('insert', function (): void {

    expect(
        (string) $stmt = new MySQLInsert()
        ->lowPriority()
        ->highPriority()
        ->ignore()
        ->into('t1')
        ->columns('c1')
        ->values([1])
        ->set('c1', 1)
        ->select('SELECT')
        ->as('new')
        ->onDuplicateKeyUpdate('c1', 1)
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'INSERT',
            'LOW_PRIORITY',
            'HIGH_PRIORITY',
            'IGNORE',
            'INTO t1',
            '(c1)',
            'VALUES (?)',
            'SET c1 = ?',
            'SELECT',
            'AS new',
            'ON DUPLICATE KEY UPDATE c1 = ?',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1, 1, 1]);

});
