<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Upsert;
use MichaelRushton\Database\SQL\Components\Where;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('where index single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $upsert = new Upsert()
        ->whereIndex($column)
    )
    ->toBe("WHERE $expected DO NOTHING");

    expect($upsert->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['c1' => 'test', 'c2' => 1], 'c1 = ? AND c2 = ?', ['test', 1]],
]);

test('where index implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $upsert = new Upsert()
        ->whereIndex('c1', $value)
    )
    ->toBe("WHERE c1 $expected DO NOTHING");

    expect($upsert->bindings())
    ->toBe($bindings);

})
->with([
    ['test', '= ?', ['test']],
    [1, '= ?', [1]],
    [1.1, '= ?', [1.1]],
    [true, '= ?', [true]],
    [['test', 1], '= (?, ?)', ['test', 1]],
    [new Raw('?', 'test'), '= ?', ['test']],
    [new SQLiteSelect(), '= (SELECT *)'],
]);

test('where index explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $upsert = new Upsert()
        ->whereIndex('c1', '!=', $value)
    )
    ->toBe("WHERE c1 != $expected DO NOTHING");

    expect($upsert->bindings())
    ->toBe($bindings);

})
->with([
    ['test', '?', ['test']],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [['test', 1], '(?, ?)', ['test', 1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('where index callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $upsert = new Upsert()
        ->whereIndex(function (Where $where) use ($column): void {
            $where->where($column);
        })
    )
    ->toBe("WHERE $expected DO NOTHING");

    expect($upsert->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['c1' => 'test', 'c2' => 1], '(c1 = ? AND c2 = ?)', ['test', 1]],
]);
