<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\SelectInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteSelectInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('extends statement', function (): void {

    expect(new SQLiteSelect())
    ->toBeInstanceOf(Statement::class);

});

test('implements select interface', function (): void {

    expect(new SQLiteSelect())
    ->toBeInstanceOf(SelectInterface::class);

});

test('implements sqlite select interface', function (): void {

    expect(new SQLiteSelect())
    ->toBeInstanceOf(SQLiteSelectInterface::class);

});

test('connection', function (): void {

    expect(new SQLiteSelect()->connection())
    ->toBeInstanceOf(SQLiteConnection::class);

});

test('select', function (): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->with('cte', 'SELECT')
        ->distinct()
        ->columns('c1')
        ->from('t1')
        ->join('t2')
        ->where('c1', 1)
        ->groupBy('c1')
        ->having('c1', 1)
        ->window('w1')
        ->union('SELECT')
        ->orderBy('c1')
        ->limit(1)
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'SELECT',
        'DISTINCT',
        'c1',
        'FROM t1',
        'JOIN t2',
        'WHERE c1 = ?',
        'GROUP BY c1',
        'HAVING c1 = ?',
        'WINDOW w1 AS ()',
        'UNION SELECT',
        'ORDER BY c1',
        'LIMIT 1',
    ]));

    expect($stmt->bindings())
    ->toBe([1, 1]);

});
