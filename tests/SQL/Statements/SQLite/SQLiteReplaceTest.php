<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\ReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteReplaceInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteReplace;

test('extends statement', function (): void {

    expect(new SQLiteReplace())
    ->toBeInstanceOf(Statement::class);

});

test('implements replace interface', function (): void {

    expect(new SQLiteReplace())
    ->toBeInstanceOf(ReplaceInterface::class);

});

test('implements sqlite replace interface', function (): void {

    expect(new SQLiteReplace())
    ->toBeInstanceOf(SQLiteReplaceInterface::class);

});

test('connection', function (): void {

    expect(new SQLiteReplace()->connection())
    ->toBeInstanceOf(SQLiteConnection::class);

});

test('replace', function (): void {

    expect(
        (string) $stmt = new SQLiteReplace()
        ->with('cte', 'SELECT')
        ->into('t1')
        ->columns('c1')
        ->values([1])
        ->select('SELECT')
        ->returning()
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'WITH cte AS (SELECT)',
            'REPLACE',
            'INTO t1',
            '(c1)',
            'VALUES (?)',
            'SELECT',
            'RETURNING *',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1]);

});
