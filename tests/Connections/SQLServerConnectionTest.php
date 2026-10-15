<?php

declare(strict_types=1);

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\SQLServerConnection;
use MichaelRushton\Database\Drivers\SQLServerDriver;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\SQLServerConnectionInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;
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

    expect(new SQLServerConnection($driver = new SQLServerDriver())->driver())
    ->toBe($driver);

});

test('settings', function (): void {

    expect(new SQLServerConnection()->settings())
    ->toBeInstanceOf(ConnectionSettings::class);

    expect(new SQLServerConnection(settings: $settings = new ConnectionSettings())->settings())
    ->toBe($settings);

});

test('cache', function (): void {

    expect(new SQLServerConnection()->cache())
    ->toBeInstanceOf(Cache::class);

    expect(new SQLServerConnection(cache: $cache = new Cache())->cache())
    ->toBe($cache);

});

test('event manager', function (): void {

    expect(new SQLServerConnection()->eventManager())
    ->toBeInstanceOf(EventManager::class);

    expect(new SQLServerConnection(event_manager: $event_manager = new EventManager())->eventManager())
    ->toBe($event_manager);

});

test('delete', function (): void {

    $connection = new SQLServerConnection();

    expect($stmt = $connection->delete())
    ->toBeInstanceOf(SQLServerDelete::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('insert', function (): void {

    $connection = new SQLServerConnection();

    expect($stmt = $connection->insert())
    ->toBeInstanceOf(SQLServerInsert::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('select', function (): void {

    $connection = new SQLServerConnection();

    expect($stmt = $connection->select())
    ->toBeInstanceOf(SQLServerSelect::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('update', function (): void {

    $connection = new SQLServerConnection();

    expect($stmt = $connection->update())
    ->toBeInstanceOf(SQLServerUpdate::class);

    expect($stmt->connection())
    ->toBe($connection);

});
