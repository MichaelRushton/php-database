<?php

declare(strict_types=1);

use MichaelRushton\Database\Driver;
use MichaelRushton\Database\Drivers\SQLServerDriver;
use MichaelRushton\Database\Interfaces\DriverInterface;

test('extends driver', function (): void {

    expect(new SQLServerDriver())
    ->toBeInstanceOf(Driver::class);

});

test('implements driver interface', function (): void {

    expect(new SQLServerDriver())
    ->toBeInstanceOf(DriverInterface::class);

});

test('default username', function (): void {

    expect(new SQLServerDriver()->username)
    ->toBe('sa');

});

test('custom username', function (): void {

    expect(new SQLServerDriver(username: 'username')->username)
    ->toBe('username');

});

test('default password', function (): void {

    expect(new SQLServerDriver()->password)
    ->toBeNull();

});

test('custom password', function (): void {

    expect(new SQLServerDriver(password: 'password')->password)
    ->toBe('password');

});

test('default dsn', function (): void {

    expect(new SQLServerDriver()->dsn)
    ->toBe('sqlsrv:Server=');

});

test('custom dsn', function (): void {

    expect(
        new SQLServerDriver(
            Server: 'Server',
            AccessToken: 'AccessToken',
            APP: 'APP',
            ApplicationIntent: 'ApplicationIntent',
            AttachDBFileName: 'AttachDBFileName',
            Authentication: 'Authentication',
            ColumnEncryption: 'ColumnEncryption',
            ConnectionPooling: true,
            ConnectRetryCount: 2,
            ConnectRetryInterval: 3,
            Database: 'Database',
            Driver: 'Driver',
            Encrypt: false,
            Failover_Partner: 'Failover_Partner',
            KeyStoreAuthentication: 'KeyStoreAuthentication',
            KeyStorePrincipalId: 'KeyStorePrincipalId',
            KeyStoreSecret: 'KeyStoreSecret',
            Language: 'Language',
            LoginTimeout: 'LoginTimeout',
            MultipleActiveResultSets: true,
            MultiSubnetFailover: 'MultiSubnetFailover',
            QuotedId: false,
            Scrollable: 'Scrollable',
            TraceFile: 'TraceFile',
            TraceOn: true,
            TransactionIsolation: 'TransactionIsolation',
            TransparentNetworkIPResolution: 'TransparentNetworkIPResolution',
            TrustServerCertificate: false,
            WSID: 'WSID'
        )
            ->dsn
    )
    ->toBe('sqlsrv:' . implode(';', array_filter([
        'Server=Server',
        'AccessToken=AccessToken',
        'APP=APP',
        'ApplicationIntent=ApplicationIntent',
        'AttachDBFileName=AttachDBFileName',
        'Authentication=Authentication',
        'ColumnEncryption=ColumnEncryption',
        'ConnectionPooling=1',
        'ConnectRetryCount=2',
        'ConnectRetryInterval=3',
        'Database=Database',
        'Driver=Driver',
        'Encrypt=0',
        'Failover_Partner=Failover_Partner',
        'KeyStoreAuthentication=KeyStoreAuthentication',
        'KeyStorePrincipalId=KeyStorePrincipalId',
        'KeyStoreSecret=KeyStoreSecret',
        'Language=Language',
        'LoginTimeout=LoginTimeout',
        'MultipleActiveResultSets=1',
        'MultiSubnetFailover=MultiSubnetFailover',
        'QuotedId=0',
        'Scrollable=Scrollable',
        'TraceFile=TraceFile',
        'TraceOn=1',
        'TransactionIsolation=TransactionIsolation',
        'TransparentNetworkIPResolution=TransparentNetworkIPResolution',
        'TrustServerCertificate=0',
        'WSID=WSID',
    ])));

});

test('default pdo options', function (): void {

    expect(new SQLServerDriver()->pdo_options)
    ->toBeNull();

});

test('custom pdo options', function (): void {

    expect(new SQLServerDriver(pdo_options: [1 => 2])->pdo_options)
    ->toBe([1 => 2]);

});
