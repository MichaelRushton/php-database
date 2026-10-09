<?php

declare(strict_types=1);

use MichaelRushton\Database\Driver;
use MichaelRushton\Database\Drivers\PostgreSQLDriver;
use MichaelRushton\Database\Interfaces\DriverInterface;

test('extends driver', function (): void {

    expect(new PostgreSQLDriver())
    ->toBeInstanceOf(Driver::class);

});

test('implements driver interface', function (): void {

    expect(new PostgreSQLDriver())
    ->toBeInstanceOf(DriverInterface::class);

});

test('default username', function (): void {

    expect(new PostgreSQLDriver()->username)
    ->toBe('postgres');

});

test('custom username', function (): void {

    expect(new PostgreSQLDriver(username: 'username')->username)
    ->toBe('username');

});

test('default password', function (): void {

    expect(new PostgreSQLDriver()->password)
    ->toBeNull();

});

test('custom password', function (): void {

    expect(new PostgreSQLDriver(password: 'password')->password)
    ->toBe('password');

});

test('default dsn', function (): void {

    expect(new PostgreSQLDriver()->dsn)
    ->toBe('pgsql:host=127.0.0.1;port=5432;dbname=postgres;sslmode=prefer');

});

test('custom dsn', function (): void {

    expect(
        new PostgreSQLDriver(
            host: 'localhost',
            port: 5433,
            dbname: 'dbname',
            sslmode: 'require',
        )
            ->dsn
    )
    ->toBe('pgsql:host=localhost;port=5433;dbname=dbname;sslmode=require');

});

test('default pdo options', function (): void {

    expect(new PostgreSQLDriver()->pdo_options)
    ->toBeNull();

});

test('custom pdo options', function (): void {

    expect(new PostgreSQLDriver(pdo_options: [1 => 2])->pdo_options)
    ->toBe([1 => 2]);

});
