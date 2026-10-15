<?php

declare(strict_types=1);

use MichaelRushton\Database\Driver;
use MichaelRushton\Database\Drivers\MySQLDriver;
use MichaelRushton\Database\Interfaces\DriverInterface;

test('extends driver', function (): void {

    expect(new MySQLDriver())
    ->toBeInstanceOf(Driver::class);

});

test('implements driver interface', function (): void {

    expect(new MySQLDriver())
    ->toBeInstanceOf(DriverInterface::class);

});

test('default username', function (): void {

    expect(new MySQLDriver()->username)
    ->toBe('root');

});

test('custom username', function (): void {

    expect(new MySQLDriver(username: 'username')->username)
    ->toBe('username');

});

test('default password', function (): void {

    expect(new MySQLDriver()->password)
    ->toBeNull();

});

test('custom password', function (): void {

    expect(new MySQLDriver(password: 'password')->password)
    ->toBe('password');

});

test('default dsn', function (): void {

    expect(new MySQLDriver()->dsn)
    ->toBe('mysql:host=127.0.0.1;port=3306');

});

test('custom dsn', function (): void {

    expect(
        new MySQLDriver(
            host: 'localhost',
            port: 3307,
            dbname: 'dbname',
            charset: 'utf8mb4',
        )
            ->dsn
    )
    ->toBe('mysql:host=localhost;port=3307;dbname=dbname;charset=utf8mb4');

});

test('dsn with unix socket', function (): void {

    expect(new MySQLDriver(unix_socket: '/tmp/mysql.sock')->dsn)
    ->toBe('mysql:unix_socket=/tmp/mysql.sock');

});

test('default pdo options', function (): void {

    expect(new MySQLDriver()->pdo_options)
    ->toBeNull();

});

test('custom pdo options', function (): void {

    expect(new MySQLDriver(pdo_options: [1 => 2])->pdo_options)
    ->toBe([1 => 2]);

});
