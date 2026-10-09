<?php

declare(strict_types=1);

use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Drivers\MySQLDriver;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\MySQLConnectionInterface;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLDelete;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLInsert;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLReplace;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLSelect;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLUpdate;

test('extends connection', function (): void {

    expect(new MySQLConnection())
    ->toBeInstanceOf(Connection::class);

});

test('implements connection interface', function (): void {

    expect(new MySQLConnection())
    ->toBeInstanceOf(ConnectionInterface::class);

});

test('implements mariadb connection interface', function (): void {

    expect(new MySQLConnection())
    ->toBeInstanceOf(MySQLConnectionInterface::class);

});

test('driver', function (): void {

    expect(new MySQLConnection()->driver())
    ->toBeInstanceOf(MySQLDriver::class);

});

test('delete', function (): void {

    expect(new MySQLConnection()->delete())
    ->toBeInstanceOf(MySQLDelete::class);

});

test('insert', function (): void {

    expect(new MySQLConnection()->insert())
    ->toBeInstanceOf(MySQLInsert::class);

});

test('replace', function (): void {

    expect(new MySQLConnection()->replace())
    ->toBeInstanceOf(MySQLReplace::class);

});

test('select', function (): void {

    expect(new MySQLConnection()->select())
    ->toBeInstanceOf(MySQLSelect::class);

});

test('update', function (): void {

    expect(new MySQLConnection()->update())
    ->toBeInstanceOf(MySQLUpdate::class);

});
