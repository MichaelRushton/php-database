<?php

declare(strict_types=1);

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Connection;
use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Drivers\SQLiteDriver;
use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\ConnectionInterface;
use MichaelRushton\Database\Interfaces\Connections\SQLiteConnectionInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;
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

    expect(new SQLiteConnection($driver = new SQLiteDriver())->driver())
    ->toBe($driver);

});

test('settings', function (): void {

    expect(new SQLiteConnection()->settings())
    ->toBeInstanceOf(ConnectionSettings::class);

    expect(new SQLiteConnection(settings: $settings = new ConnectionSettings())->settings())
    ->toBe($settings);

});

test('cache', function (): void {

    expect(new SQLiteConnection()->cache())
    ->toBeInstanceOf(Cache::class);

    expect(new SQLiteConnection(cache: $cache = new Cache())->cache())
    ->toBe($cache);

});

test('event manager', function (): void {

    expect(new SQLiteConnection()->eventManager())
    ->toBeInstanceOf(EventManager::class);

    expect(new SQLiteConnection(event_manager: $event_manager = new EventManager())->eventManager())
    ->toBe($event_manager);

});

test('delete', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->delete())
    ->toBeInstanceOf(SQLiteDelete::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('insert', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->insert())
    ->toBeInstanceOf(SQLiteInsert::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('replace', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->replace())
    ->toBeInstanceOf(SQLiteReplace::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('select', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->select())
    ->toBeInstanceOf(SQLiteSelect::class);

    expect($stmt->connection())
    ->toBe($connection);

});

test('update', function (): void {

    $connection = new SQLiteConnection();

    expect($stmt = $connection->update())
    ->toBeInstanceOf(SQLiteUpdate::class);

    expect($stmt->connection())
    ->toBe($connection);

});
