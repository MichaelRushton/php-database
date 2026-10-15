<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Having;
use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('empty having', function (): void {

    expect((string) new Having())
    ->toBe('');

});

test('having single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having($column)
    )
    ->toBe($expected);

    expect($having->bindings())
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

test('having implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c1', $value)
    )
    ->toBe("c1 $expected");

    expect($having->bindings())
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

test('having explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c1', '!=', $value)
    )
    ->toBe("c1 != $expected");

    expect($having->bindings())
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

test('having callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having(function (Having $having) use ($column): void {
            $having->having($column);
        })
    )
    ->toBe($expected);

    expect($having->bindings())
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

test('or having single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHaving($column)
    )
    ->toBe("(c0 OR $expected)");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['c1' => 'test', 'c2' => 1], 'c1 = ? OR c2 = ?', ['test', 1]],
]);

test('or having implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHaving('c1', $value)
    )
    ->toBe("(c0 OR c1 $expected)");

    expect($having->bindings())
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

test('or having explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHaving('c1', '!=', $value)
    )
    ->toBe("(c0 OR c1 != $expected)");

    expect($having->bindings())
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

test('or having callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHaving(function (Having $having) use ($column): void {
            $having->having($column);
        })
    )
    ->toBe("(c0 OR $expected)");

    expect($having->bindings())
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

test('having not single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNot($column)
    )
    ->toBe($expected);

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'NOT c1'],
    [1, 'NOT ?', [1]],
    [1.1, 'NOT ?', [1.1]],
    [true, 'NOT ?', [true]],
    [new Raw('?', 'test'), 'NOT ?', ['test']],
    [new SQLiteSelect(), 'NOT (SELECT *)'],
    [['c1' => 'test', 'c2' => 1], '(NOT c1 = ? AND NOT c2 = ?)', ['test', 1]],
]);

test('having not implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNot('c1', $value)
    )
    ->toBe("NOT c1 $expected");

    expect($having->bindings())
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

test('having not explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNot('c1', '!=', $value)
    )
    ->toBe("NOT c1 != $expected");

    expect($having->bindings())
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

test('having not callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNot(function (Having $having) use ($column): void {
            $having->having($column);
        })
    )
    ->toBe("NOT $expected");

    expect($having->bindings())
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

test('or having not single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNot($column)
    )
    ->toBe("(c0 OR NOT $expected)");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['c1' => 'test', 'c2' => 1], 'c1 = ? OR NOT c2 = ?', ['test', 1]],
]);

test('or having not implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNot('c1', $value)
    )
    ->toBe("(c0 OR NOT c1 $expected)");

    expect($having->bindings())
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

test('or having not explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNot('c1', '!=', $value)
    )
    ->toBe("(c0 OR NOT c1 != $expected)");

    expect($having->bindings())
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

test('or having not callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNot(function (Having $having) use ($column): void {
            $having->having($column);
        })
    )
    ->toBe("(c0 OR NOT $expected)");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [['c1' => 'test', 'c2' => 1], '(c1 = ? AND c2 = ?)', ['test', 1]],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('having in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingIn($column, ['test', 1])
    )
    ->toBe("$expected IN (?, ?)");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or having in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingIn($column, ['test', 1])
    )
    ->toBe("(c0 OR $expected IN (?, ?))");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('having not in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNotIn($column, ['test', 1])
    )
    ->toBe("NOT $expected IN (?, ?)");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or having not in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNotIn($column, ['test', 1])
    )
    ->toBe("(c0 OR NOT $expected IN (?, ?))");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [true, '?', [true]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('having between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingBetween($column, 'test', 1)
    )
    ->toBe("$expected BETWEEN ? AND ?");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or having between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingBetween($column, 'test', 1)
    )
    ->toBe("(c0 OR $expected BETWEEN ? AND ?)");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('having not between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNotBetween($column, 'test', 1)
    )
    ->toBe("NOT $expected BETWEEN ? AND ?");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or having not between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNotBetween($column, 'test', 1)
    )
    ->toBe("(c0 OR NOT $expected BETWEEN ? AND ?)");

    expect($having->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('having null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNull($column)
    )
    ->toBe("$expected IS NULL");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or having null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNull($column)
    )
    ->toBe("(c0 OR $expected IS NULL)");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('having not null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->havingNotNull($column)
    )
    ->toBe("NOT $expected IS NULL");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or having not null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $having = new Having()
        ->having('c0')
        ->orHavingNotNull($column)
    )
    ->toBe("(c0 OR NOT $expected IS NULL)");

    expect($having->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);
