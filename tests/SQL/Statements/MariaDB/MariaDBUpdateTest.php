<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBUpdateInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBUpdate;

test('extends statement', function (): void {

    expect(new MariaDBUpdate())
    ->toBeInstanceOf(Statement::class);

});

test('implements update interface', function (): void {

    expect(new MariaDBUpdate())
    ->toBeInstanceOf(UpdateInterface::class);

});

test('implements mariadb update interface', function (): void {

    expect(new MariaDBUpdate())
    ->toBeInstanceOf(MariaDBUpdateInterface::class);

});

test('connection', function (): void {

    expect(new MariaDBUpdate()->connection())
    ->toBeInstanceOf(MariaDBConnection::class);

});

test('update', function (): void {

    expect(
        (string) new MariaDBUpdate()
        ->with('cte', 'SELECT')
        ->lowPriority()
        ->ignore()
        ->table('t1')
        ->join('t1')
        ->set('c1', 1)
        ->where('c1')
        ->orderBy('c1')
        ->limit(1)
        ->returning()
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
        'RETURNING *',
    ]));

});
