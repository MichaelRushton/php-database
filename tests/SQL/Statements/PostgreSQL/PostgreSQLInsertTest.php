<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLInsert;

test('extends statement', function (): void {

    expect(new PostgreSQLInsert())
    ->toBeInstanceOf(Statement::class);

});

test('implements insert interface', function (): void {

    expect(new PostgreSQLInsert())
    ->toBeInstanceOf(InsertInterface::class);

});

test('implements postgresql insert interface', function (): void {

    expect(new PostgreSQLInsert())
    ->toBeInstanceOf(PostgreSQLInsertInterface::class);

});

test('connection', function (): void {

    expect(new PostgreSQLInsert()->connection())
    ->toBeInstanceOf(PostgreSQLConnection::class);

});

test('insert', function (): void {

    expect(
        (string) $stmt = new PostgreSQLInsert()
        ->with('cte', 'SELECT')
        ->into('t1')
        ->columns('c1')
        ->overridingSystemValue()
        ->values([1])
        ->select('SELECT')
        ->onConflictDoNothing()
        ->returning()
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'WITH cte AS (SELECT)',
            'INSERT',
            'INTO t1',
            '(c1)',
            'OVERRIDING SYSTEM VALUE',
            'VALUES (?)',
            'SELECT',
            'ON CONFLICT DO NOTHING',
            'RETURNING *',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1]);

});
