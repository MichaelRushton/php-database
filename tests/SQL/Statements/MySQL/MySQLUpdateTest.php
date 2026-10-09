<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLUpdateInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLUpdate;

test('extends statement', function (): void {

    expect(new MySQLUpdate())
    ->toBeInstanceOf(Statement::class);

});

test('implements update interface', function (): void {

    expect(new MySQLUpdate())
    ->toBeInstanceOf(UpdateInterface::class);

});

test('implements mysql update interface', function (): void {

    expect(new MySQLUpdate())
    ->toBeInstanceOf(MySQLUpdateInterface::class);

});

test('connection', function (): void {

    expect(new MySQLUpdate()->connection())
    ->toBeInstanceOf(MySQLConnection::class);

});

test('update', function (): void {

    expect(
        (string) new MySQLUpdate()
        ->with('cte', 'SELECT')
        ->lowPriority()
        ->ignore()
        ->table('t1')
        ->join('t1')
        ->set('c1', 1)
        ->where('c1')
        ->orderBy('c1')
        ->limit(1)
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'UPDATE',
        'LOW_PRIORITY',
        'IGNORE',
        't1',
        'JOIN t1',
        'SET c1 = ?',
        'WHERE c1',
        'ORDER BY c1',
        'LIMIT 1',
    ]));

});
