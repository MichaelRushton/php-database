<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLServer\SQLServerDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerDelete;

test('extends statement', function (): void {

    expect(new SQLServerDelete())
    ->toBeInstanceOf(Statement::class);

});

test('implements delete interface', function (): void {

    expect(new SQLServerDelete())
    ->toBeInstanceOf(DeleteInterface::class);

});

test('implements sqlserver delete interface', function (): void {

    expect(new SQLServerDelete())
    ->toBeInstanceOf(SQLServerDeleteInterface::class);

});

test('connection', function (): void {

    expect(new SQLServerDelete()->connection())
    ->toBeInstanceOf(SQLServerConnection::class);

});

test('delete', function (): void {

    expect(
        (string) new SQLServerDelete()
        ->with('cte', 'SELECT')
        ->top(1)
        ->table('t1')
        ->output('*')
        ->from('t1')
        ->join('t1')
        ->where('c1')
        ->whereCurrentOf('cursor')
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'DELETE',
        'TOP (1)',
        't1',
        'OUTPUT *',
        'FROM t1',
        'JOIN t1',
        'WHERE c1',
        'WHERE CURRENT OF cursor',
    ]));

});
