<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerUpdateInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerUpdate;

test('extends statement', function (): void {

    expect(new SQLServerUpdate())
    ->toBeInstanceOf(Statement::class);

});

test('implements update interface', function (): void {

    expect(new SQLServerUpdate())
    ->toBeInstanceOf(UpdateInterface::class);

});

test('implements sqlserver update interface', function (): void {

    expect(new SQLServerUpdate())
    ->toBeInstanceOf(SQLServerUpdateInterface::class);

});

test('connection', function (): void {

    expect(new SQLServerUpdate()->connection())
    ->toBeInstanceOf(SQLServerConnection::class);

});

test('update', function (): void {

    expect(
        (string) new SQLServerUpdate()
        ->with('cte', 'SELECT')
        ->top(1)
        ->table('t1')
        ->set('c1', 1)
        ->output('*')
        ->from('t1')
        ->join('t1')
        ->where('c1')
        ->whereCurrentOf('cursor')
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'UPDATE',
        'TOP (1)',
        't1',
        'SET c1 = ?',
        'OUTPUT *',
        'FROM t1',
        'JOIN t1',
        'WHERE c1',
        'WHERE CURRENT OF cursor',
    ]));

});
