<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBDelete;

test('extends statement', function (): void {

    expect(new MariaDBDelete())
    ->toBeInstanceOf(Statement::class);

});

test('implements delete interface', function (): void {

    expect(new MariaDBDelete())
    ->toBeInstanceOf(DeleteInterface::class);

});

test('implements mariadb delete interface', function (): void {

    expect(new MariaDBDelete())
    ->toBeInstanceOf(MariaDBDeleteInterface::class);

});

test('connection', function (): void {

    expect(new MariaDBDelete()->connection())
    ->toBeInstanceOf(MariaDBConnection::class);

});

test('delete', function (): void {

    expect(
        (string) new MariaDBDelete()
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
        ->returning()
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
        'RETURNING *',
    ]));

});
