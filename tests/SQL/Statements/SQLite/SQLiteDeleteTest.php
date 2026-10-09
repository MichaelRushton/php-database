<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteDelete;

test('extends statement', function (): void {

    expect(new SQLiteDelete())
    ->toBeInstanceOf(Statement::class);

});

test('implements delete interface', function (): void {

    expect(new SQLiteDelete())
    ->toBeInstanceOf(DeleteInterface::class);

});

test('implements sqlite delete interface', function (): void {

    expect(new SQLiteDelete())
    ->toBeInstanceOf(SQLiteDeleteInterface::class);

});

test('connection', function (): void {

    expect(new SQLiteDelete()->connection())
    ->toBeInstanceOf(SQLiteConnection::class);

});

test('delete', function (): void {

    expect(
        (string) $stmt = new SQLiteDelete()
        ->with('cte', 'SELECT')
        ->from('t1')
        ->where('c1', 1)
        ->returning()
        ->orderBy('c1')
        ->limit(1)
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'DELETE',
        'FROM t1',
        'WHERE c1 = ?',
        'RETURNING *',
        'ORDER BY c1',
        'LIMIT 1',
    ]));

    expect($stmt->bindings())
    ->toBe([1]);

});
