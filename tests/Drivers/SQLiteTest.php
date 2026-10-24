<?php

declare(strict_types=1);

use MichaelRushton\Database\Driver;
use MichaelRushton\Database\Drivers\SQLiteDriver;
use MichaelRushton\Database\Interfaces\DriverInterface;

test('extends driver', function (): void {

    expect(new SQLiteDriver())
    ->toBeInstanceOf(Driver::class);

});

test('implements driver interface', function (): void {

    expect(new SQLiteDriver())
    ->toBeInstanceOf(DriverInterface::class);

});

test('default database', function (): void {

    expect(new SQLiteDriver()->database)
    ->toBe('');

});

test('custom database', function (): void {

    expect(new SQLiteDriver('database')->database)
    ->toBe('database');

});

test('default dsn', function (): void {

    expect(new SQLiteDriver()->dsn)
    ->toBe('sqlite:');

});

test('custom dsn', function (): void {

    expect(new SQLiteDriver('database')->dsn)
    ->toBe('sqlite:database');

});

test('default pdo options', function (): void {

    expect(new SQLiteDriver()->pdo_options)
    ->toBeNull();

});

test('custom pdo options', function (): void {

    expect(new SQLiteDriver(pdo_options: [1 => 2])->pdo_options)
    ->toBe([1 => 2]);

});

test('connect', function (): void {

    expect(new SQLiteDriver()->connect())
    ->toBeInstanceOf(Pdo\Sqlite::class);

});
