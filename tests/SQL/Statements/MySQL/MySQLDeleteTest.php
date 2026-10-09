<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLDelete;

test('extends statement', function (): void {

    expect(new MySQLDelete())
    ->toBeInstanceOf(Statement::class);

});

test('implements delete interface', function (): void {

    expect(new MySQLDelete())
    ->toBeInstanceOf(DeleteInterface::class);

});

test('implements mysql delete interface', function (): void {

    expect(new MySQLDelete())
    ->toBeInstanceOf(MySQLDeleteInterface::class);

});

test('connection', function (): void {

    expect(new MySQLDelete()->connection())
    ->toBeInstanceOf(MySQLConnection::class);

});

test('delete', function (): void {

    expect(
        (string) new MySQLDelete()
        ->with('cte', 'SELECT')
        ->lowPriority()
        ->quick()
        ->ignore()
        ->table('t1')
        ->from('t1')
        ->using('t1')
        ->join('t1')
        ->where('c1')
        ->orderBy('c1')
        ->limit(1)
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'DELETE',
        'LOW_PRIORITY',
        'QUICK',
        'IGNORE',
        't1',
        'FROM t1',
        'USING t1',
        'JOIN t1',
        'WHERE c1',
        'ORDER BY c1',
        'LIMIT 1',
    ]));

});
