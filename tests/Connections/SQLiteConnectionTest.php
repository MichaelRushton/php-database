<?php

declare(strict_types=1);

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\SQLiteConnectionInterface;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteDelete;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteInsert;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteReplace;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteUpdate;

test('extends connection', function (): void {

    expect(new SQLiteConnection())
    ->toBeInstanceOf(Connection::class);

});

test('implements connection interface', function (): void {

    expect(new SQLiteConnection())
    ->toBeInstanceOf(ConnectionInterface::class);

});

test('implements mariadb connection interface', function (): void {

    expect(new SQLiteConnection())
    ->toBeInstanceOf(SQLiteConnectionInterface::class);

});

test('driver', function (): void {

    expect(new SQLiteConnection()->driver())
    ->toBeInstanceOf(SQLiteDriver::class);

});

test('delete', function (): void {

    expect(new SQLiteConnection()->delete())
    ->toBeInstanceOf(SQLiteDelete::class);

});

test('insert', function (): void {

    expect(new SQLiteConnection()->insert())
    ->toBeInstanceOf(SQLiteInsert::class);

});

test('replace', function (): void {

    expect(new SQLiteConnection()->replace())
    ->toBeInstanceOf(SQLiteReplace::class);

});

test('select', function (): void {

    expect(new SQLiteConnection()->select())
    ->toBeInstanceOf(SQLiteSelect::class);

});

test('update', function (): void {

    expect(new SQLiteConnection()->update())
    ->toBeInstanceOf(SQLiteUpdate::class);

});
