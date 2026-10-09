<?php

declare(strict_types=1);

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Drivers\MariaDBDriver;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\MariaDBConnectionInterface;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBDelete;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBInsert;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBReplace;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBUpdate;

test('extends connection', function (): void {

    expect(new MariaDBConnection())
    ->toBeInstanceOf(Connection::class);

});

test('implements connection interface', function (): void {

    expect(new MariaDBConnection())
    ->toBeInstanceOf(ConnectionInterface::class);

});

test('implements mariadb connection interface', function (): void {

    expect(new MariaDBConnection())
    ->toBeInstanceOf(MariaDBConnectionInterface::class);

});

test('driver', function (): void {

    expect(new MariaDBConnection()->driver())
    ->toBeInstanceOf(MariaDBDriver::class);

});

test('delete', function (): void {

    expect(new MariaDBConnection()->delete())
    ->toBeInstanceOf(MariaDBDelete::class);

});

test('insert', function (): void {

    expect(new MariaDBConnection()->insert())
    ->toBeInstanceOf(MariaDBInsert::class);

});

test('replace', function (): void {

    expect(new MariaDBConnection()->replace())
    ->toBeInstanceOf(MariaDBReplace::class);

});

test('select', function (): void {

    expect(new MariaDBConnection()->select())
    ->toBeInstanceOf(MariaDBSelect::class);

});

test('update', function (): void {

    expect(new MariaDBConnection()->update())
    ->toBeInstanceOf(MariaDBUpdate::class);

});
