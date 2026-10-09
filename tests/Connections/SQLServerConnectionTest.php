<?php

declare(strict_types=1);

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Drivers\SQLServerDriver;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\SQLServerConnectionInterface;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerDelete;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerInsert;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerSelect;
use MichaelRushton\Database\SQL\Statements\SQLServer\SQLServerUpdate;

test('extends connection', function (): void {

    expect(new SQLServerConnection())
    ->toBeInstanceOf(Connection::class);

});

test('implements connection interface', function (): void {

    expect(new SQLServerConnection())
    ->toBeInstanceOf(ConnectionInterface::class);

});

test('implements mariadb connection interface', function (): void {

    expect(new SQLServerConnection())
    ->toBeInstanceOf(SQLServerConnectionInterface::class);

});

test('driver', function (): void {

    expect(new SQLServerConnection()->driver())
    ->toBeInstanceOf(SQLServerDriver::class);

});

test('delete', function (): void {

    expect(new SQLServerConnection()->delete())
    ->toBeInstanceOf(SQLServerDelete::class);

});

test('insert', function (): void {

    expect(new SQLServerConnection()->insert())
    ->toBeInstanceOf(SQLServerInsert::class);

});

test('select', function (): void {

    expect(new SQLServerConnection()->select())
    ->toBeInstanceOf(SQLServerSelect::class);

});

test('update', function (): void {

    expect(new SQLServerConnection()->update())
    ->toBeInstanceOf(SQLServerUpdate::class);

});
