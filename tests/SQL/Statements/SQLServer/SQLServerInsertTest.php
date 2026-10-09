<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerInsert;

test('extends statement', function (): void {

    expect(new SQLServerInsert())
    ->toBeInstanceOf(Statement::class);

});

test('implements insert interface', function (): void {

    expect(new SQLServerInsert())
    ->toBeInstanceOf(InsertInterface::class);

});

test('implements sqlserver insert interface', function (): void {

    expect(new SQLServerInsert())
    ->toBeInstanceOf(SQLServerInsertInterface::class);

});

test('connection', function (): void {

    expect(new SQLServerInsert()->connection())
    ->toBeInstanceOf(SQLServerConnection::class);

});

test('insert', function (): void {

    expect(
        (string) $stmt = new SQLServerInsert()
        ->with('cte', 'SELECT')
        ->top(1)
        ->into('t1')
        ->columns('c1')
        ->output('*')
        ->values([1])
        ->select('SELECT')
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'WITH cte AS (SELECT)',
            'INSERT',
            'TOP (1)',
            'INTO t1',
            '(c1)',
            'OUTPUT *',
            'VALUES (?)',
            'SELECT',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1]);

});
