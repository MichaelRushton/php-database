<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MariaDBConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\MariaDB\MariaDBReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\ReplaceInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBReplace;

test('extends statement', function (): void {

    expect(new MariaDBReplace())
    ->toBeInstanceOf(Statement::class);

});

test('implements replace interface', function (): void {

    expect(new MariaDBReplace())
    ->toBeInstanceOf(ReplaceInterface::class);

});

test('implements mariadb replace interface', function (): void {

    expect(new MariaDBReplace())
    ->toBeInstanceOf(MariaDBReplaceInterface::class);

});

test('connection', function (): void {

    expect(new MariaDBReplace()->connection())
    ->toBeInstanceOf(MariaDBConnection::class);

});

test('replace', function (): void {

    expect(
        (string) $stmt = new MariaDBReplace()
        ->lowPriority()
        ->delayed()
        ->into('t1')
        ->columns('c1')
        ->values([1])
        ->set('c1', 1)
        ->select('SELECT')
        ->returning()
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'REPLACE',
            'LOW_PRIORITY',
            'DELAYED',
            'INTO t1',
            '(c1)',
            'VALUES (?)',
            'SET c1 = ?',
            'SELECT',
            'RETURNING *',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1, 1]);

});
