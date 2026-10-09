<?php

declare(strict_types=1);

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Drivers\PostgreSQLDriver;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\PostgreSQLConnectionInterface;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLDelete;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLInsert;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLSelect;
use MichaelRushton\Database\SQL\Statements\PostgreSQL\PostgreSQLUpdate;

test('extends connection', function (): void {

    expect(new PostgreSQLConnection())
    ->toBeInstanceOf(Connection::class);

});

test('implements connection interface', function (): void {

    expect(new PostgreSQLConnection())
    ->toBeInstanceOf(ConnectionInterface::class);

});

test('implements mariadb connection interface', function (): void {

    expect(new PostgreSQLConnection())
    ->toBeInstanceOf(PostgreSQLConnectionInterface::class);

});

test('driver', function (): void {

    expect(new PostgreSQLConnection()->driver())
    ->toBeInstanceOf(PostgreSQLDriver::class);

});

test('delete', function (): void {

    expect(new PostgreSQLConnection()->delete())
    ->toBeInstanceOf(PostgreSQLDelete::class);

});

test('insert', function (): void {

    expect(new PostgreSQLConnection()->insert())
    ->toBeInstanceOf(PostgreSQLInsert::class);

});

test('select', function (): void {

    expect(new PostgreSQLConnection()->select())
    ->toBeInstanceOf(PostgreSQLSelect::class);

});

test('update', function (): void {

    expect(new PostgreSQLConnection()->update())
    ->toBeInstanceOf(PostgreSQLUpdate::class);

});
