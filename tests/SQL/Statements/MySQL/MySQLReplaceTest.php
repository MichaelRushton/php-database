<?php

declare(strict_types=1);

use MichaelRushton\Database\Connections\MySQLConnection;
use MichaelRushton\Database\Interfaces\SQL\Statements\MySQL\MySQLReplaceInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\ReplaceInterface;
use MichaelRushton\Database\SQL\Statement;
use MichaelRushton\Database\SQL\Statements\MySQL\MySQLReplace;

test('extends statement', function (): void {

    expect(new MySQLReplace())
    ->toBeInstanceOf(Statement::class);

});

test('implements replace interface', function (): void {

    expect(new MySQLReplace())
    ->toBeInstanceOf(ReplaceInterface::class);

});

test('implements mysql replace interface', function (): void {

    expect(new MySQLReplace())
    ->toBeInstanceOf(MySQLReplaceInterface::class);

});

test('connection', function (): void {

    expect(new MySQLReplace()->connection())
    ->toBeInstanceOf(MySQLConnection::class);

});

test('replace', function (): void {

    expect(
        (string) $stmt = new MySQLReplace()
        ->lowPriority()
        ->into('t1')
        ->columns('c1')
        ->values([1])
        ->set('c1', 1)
        ->select('SELECT')
        ->when(0)
    )
    ->toBe(
        implode(' ', [
            'REPLACE',
            'LOW_PRIORITY',
            'INTO t1',
            '(c1)',
            'VALUES (?)',
            'SET c1 = ?',
            'SELECT',
        ])
    );

    expect($stmt->bindings())
    ->toBe([1, 1]);

});
