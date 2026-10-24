<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\SQL\Statements\DeleteInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\PostgreSQL\PostgreSQLDeleteInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLDelete;

test('extends statement', function (): void {

    expect(new PostgreSQLDelete())
    ->toBeInstanceOf(Statement::class);

});

test('implements delete interface', function (): void {

    expect(new PostgreSQLDelete())
    ->toBeInstanceOf(DeleteInterface::class);

});

test('implements postgresql delete interface', function (): void {

    expect(new PostgreSQLDelete())
    ->toBeInstanceOf(PostgreSQLDeleteInterface::class);

});

test('connection', function (): void {

    expect(new PostgreSQLDelete()->connection)
    ->toBeInstanceOf(PostgreSQLConnection::class);

    expect(new PostgreSQLDelete($connection = new PostgreSQLConnection())->connection)
    ->toBe($connection);

});

test('event manager', function (): void {

    expect(new PostgreSQLDelete()->event_manager)
    ->toBeInstanceOf(EventManager::class);

    expect(new PostgreSQLDelete(event_manager: $event_manager = new EventManager())->event_manager)
    ->toBe($event_manager);

});

test('delete', function (): void {

    expect(
        (string) $stmt = new PostgreSQLDelete()
        ->with('cte', 'SELECT')
        ->from('t1')
        ->using('t1')
        ->join('t1')
        ->where('c1', 1)
        ->whereCurrentOf('cursor')
        ->returning()
        ->when(0)
    )
    ->toBe(implode(' ', [
        'WITH cte AS (SELECT)',
        'DELETE',
        'FROM t1',
        'USING t1',
        'JOIN t1',
        'WHERE c1 = ?',
        'WHERE CURRENT OF cursor',
        'RETURNING *',
    ]));

    expect($stmt->bindings)
    ->toBe([1]);

});
