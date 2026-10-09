<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\InsertInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteInsertInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;

test('extends statement', function (): void {

    expect(new SQLiteInsert())
    ->toBeInstanceOf(Statement::class);

});

test('implements insert interface', function (): void {

    expect(new SQLiteInsert())
    ->toBeInstanceOf(InsertInterface::class);

});

test('implements sqlite insert interface', function (): void {

    expect(new SQLiteInsert())
    ->toBeInstanceOf(SQLiteInsertInterface::class);

});

test('connection', function (): void {

    expect(new SQLiteInsert()->connection())
    ->toBeInstanceOf(SQLiteConnection::class);

});

test('insert', function (): void {

    expect(
        (string) $stmt = new SQLiteInsert()
        ->with('cte', 'SELECT')
        ->orFail()
        ->into('t1')
        ->columns('c1')
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
            'OR FAIL',
            'INTO t1',
            '(c1)',
            'VALUES (?)',
            'SELECT',
            'ON CONFLICT DO NOTHING',
            'RETURNING *',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1]);

});
