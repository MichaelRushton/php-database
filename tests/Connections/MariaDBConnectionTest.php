<?php

declare(strict_types=1);

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Drivers\MariaDBDriver;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\MariaDBConnectionInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;
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

    expect(new MariaDBConnection($driver = new MariaDBDriver())->driver())
    ->toBe($driver);

});

test('settings', function (): void {

    expect(new MariaDBConnection()->settings())
    ->toBeInstanceOf(ConnectionSettings::class);

    expect(new MariaDBConnection(settings: $settings = new ConnectionSettings())->settings())
    ->toBe($settings);

});

test('cache', function (): void {

    expect(new MariaDBConnection()->cache())
    ->toBeInstanceOf(Cache::class);

    expect(new MariaDBConnection(cache: $cache = new Cache())->cache())
    ->toBe($cache);

});

test('event manager', function (): void {

    expect(new MariaDBConnection()->eventManager())
    ->toBeInstanceOf(EventManager::class);

    expect(new MariaDBConnection(event_manager: $event_manager = new EventManager())->eventManager())
    ->toBe($event_manager);

});

test('delete', function (): void {

    $connection = new MariaDBConnection();

    expect($stmt = $connection->delete())
    ->toBeInstanceOf(MariaDBDelete::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('insert', function (): void {

    $connection = new MariaDBConnection();

    expect($stmt = $connection->insert())
    ->toBeInstanceOf(MariaDBInsert::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('replace', function (): void {

    $connection = new MariaDBConnection();

    expect($stmt = $connection->replace())
    ->toBeInstanceOf(MariaDBReplace::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('select', function (): void {

    $connection = new MariaDBConnection();

    expect($stmt = $connection->select())
    ->toBeInstanceOf(MariaDBSelect::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('update', function (): void {

    $connection = new MariaDBConnection();

    expect($stmt = $connection->update())
    ->toBeInstanceOf(MariaDBUpdate::class);

    expect($stmt->connection())
    ->toBe($connection);

});
