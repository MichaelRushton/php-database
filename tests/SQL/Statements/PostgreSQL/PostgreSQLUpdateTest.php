<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLUpdateInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLUpdate;

test('extends statement', function (): void {

    expect(new PostgreSQLUpdate())
    ->toBeInstanceOf(Statement::class);

});

test('implements update interface', function (): void {

    expect(new PostgreSQLUpdate())
    ->toBeInstanceOf(UpdateInterface::class);

});

test('implements postgresql update interface', function (): void {

    expect(new PostgreSQLUpdate())
    ->toBeInstanceOf(PostgreSQLUpdateInterface::class);

});

test('connection', function (): void {

    expect(new PostgreSQLUpdate()->connection())
    ->toBeInstanceOf(PostgreSQLConnection::class);

});

test('update', function (): void {

    expect(
        (string) $stmt = new PostgreSQLUpdate()
        ->table('t1')
        ->set('c1', 1)
        ->from('t1')
        ->join('t1')
        ->where('c1')
        ->whereCurrentOf('cursor')
        ->returning()
        ->when(0)
    )
    ->toBe(implode(' ', [
        'UPDATE',
        't1',
        'SET c1 = ?',
        'FROM t1',
        'JOIN t1',
        'WHERE c1',
        'WHERE CURRENT OF cursor',
        'RETURNING *',
    ]));

    expect($stmt->bindings())
    ->toBe([1]);

});
