<?php

declare(strict_types=1);

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Configuration;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Drivers\MySQLDriver;
use MichaelRushton\Database\EventManager;
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

    expect(new MySQLConnection()->driver)
    ->toBeInstanceOf(MySQLDriver::class);

    expect(new MySQLConnection($driver = new MySQLDriver())->driver)
    ->toBe($driver);

});

test('configuration', function (): void {

    expect(new MySQLConnection()->configuration)
    ->toBeInstanceOf(Configuration::class);

    expect(new MySQLConnection(configuration: $configuration = new Configuration())->configuration)
    ->toBe($configuration);

});

test('cache', function (): void {

    expect(new MySQLConnection()->cache)
    ->toBeInstanceOf(Cache::class);

    expect(new MySQLConnection(cache: $cache = new Cache())->cache)
    ->toBe($cache);

});

test('event manager', function (): void {

    expect(new MySQLConnection()->event_manager)
    ->toBeInstanceOf(EventManager::class);

    expect(new MySQLConnection(event_manager: $event_manager = new EventManager())->event_manager)
    ->toBe($event_manager);

});

test('delete', function (): void {

    $connection = new MySQLConnection();

    expect($stmt = $connection->delete())
    ->toBeInstanceOf(MySQLDelete::class);

    expect($stmt->connection)
    ->toBe($connection);

});

test('insert', function (): void {

    $connection = new MySQLConnection();

    expect($stmt = $connection->insert())
    ->toBeInstanceOf(MySQLInsert::class);

    expect($stmt->connection)
    ->toBe($connection);

});

test('replace', function (): void {

    $connection = new MySQLConnection();

    expect($stmt = $connection->replace())
    ->toBeInstanceOf(MySQLReplace::class);

    expect($stmt->connection)
    ->toBe($connection);

});

test('select', function (): void {

    $connection = new MySQLConnection();

    expect($stmt = $connection->select())
    ->toBeInstanceOf(MySQLSelect::class);

    expect($stmt->connection)
    ->toBe($connection);

});

test('update', function (): void {

    $connection = new MySQLConnection();

    expect($stmt = $connection->update())
    ->toBeInstanceOf(MySQLUpdate::class);

    expect($stmt->connection)
    ->toBe($connection);

});
