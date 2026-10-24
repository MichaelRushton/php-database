<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\SQL\Statements\SQLite\SQLiteUpdateInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\UpdateInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteUpdate;

test('extends statement', function (): void {

    expect(new SQLiteUpdate())
    ->toBeInstanceOf(Statement::class);

});

test('implements update interface', function (): void {

    expect(new SQLiteUpdate())
    ->toBeInstanceOf(UpdateInterface::class);

});

test('implements sqlite update interface', function (): void {

    expect(new SQLiteUpdate())
    ->toBeInstanceOf(SQLiteUpdateInterface::class);

});

test('connection', function (): void {

    expect(new SQLiteUpdate()->connection)
    ->toBeInstanceOf(SQLiteConnection::class);

    expect(new SQLiteUpdate($connection = new SQLiteConnection())->connection)
    ->toBe($connection);

});

test('event manager', function (): void {

    expect(new SQLiteUpdate()->event_manager)
    ->toBeInstanceOf(EventManager::class);

    expect(new SQLiteUpdate(event_manager: $event_manager = new EventManager())->event_manager)
    ->toBe($event_manager);

});

test('update', function (): void {

    expect(
        (string) $stmt = new SQLiteUpdate()
        ->orFail()
        ->table('t1')
        ->set('c1', 1)
        ->from('t1')
        ->join('t1')
        ->where('c1')
        ->returning()
        ->orderBy('c1')
        ->limit(1)
        ->when(0)
    )
    ->toBe(implode(' ', [
        'UPDATE',
        'OR FAIL',
        't1',
        'SET c1 = ?',
        'FROM t1',
        'JOIN t1',
        'WHERE c1',
        'RETURNING *',
        'ORDER BY c1',
        'LIMIT 1',
    ]));

    expect($stmt->bindings)
    ->toBe([1]);

});
