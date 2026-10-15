<?php

declare(strict_types=1);

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\PostgreSQLConnection;
use MichaelRushton\Database\Drivers\PostgreSQLDriver;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\PostgreSQLConnectionInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;
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

    expect(new PostgreSQLConnection($driver = new PostgreSQLDriver())->driver())
    ->toBe($driver);

});

test('settings', function (): void {

    expect(new PostgreSQLConnection()->settings())
    ->toBeInstanceOf(ConnectionSettings::class);

    expect(new PostgreSQLConnection(settings: $settings = new ConnectionSettings())->settings())
    ->toBe($settings);

});

test('cache', function (): void {

    expect(new PostgreSQLConnection()->cache())
    ->toBeInstanceOf(Cache::class);

    expect(new PostgreSQLConnection(cache: $cache = new Cache())->cache())
    ->toBe($cache);

});

test('event manager', function (): void {

    expect(new PostgreSQLConnection()->eventManager())
    ->toBeInstanceOf(EventManager::class);

    expect(new PostgreSQLConnection(event_manager: $event_manager = new EventManager())->eventManager())
    ->toBe($event_manager);

});

test('delete', function (): void {

    $connection = new PostgreSQLConnection();

    expect($stmt = $connection->delete())
    ->toBeInstanceOf(PostgreSQLDelete::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('insert', function (): void {

    $connection = new PostgreSQLConnection();

    expect($stmt = $connection->insert())
    ->toBeInstanceOf(PostgreSQLInsert::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('select', function (): void {

    $connection = new PostgreSQLConnection();

    expect($stmt = $connection->select())
    ->toBeInstanceOf(PostgreSQLSelect::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('update', function (): void {

    $connection = new PostgreSQLConnection();

    expect($stmt = $connection->update())
    ->toBeInstanceOf(PostgreSQLUpdate::class);

    expect($stmt->connection())
    ->toBe($connection);

});
