<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Where;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('empty where', function (): void {

    expect((string) new Where())
    ->toBe('');

});

test('where single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where($column)
    )
    ->toBe($expected);

    expect($where->bindings())
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

test('where implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c1', $value)
    )
    ->toBe("c1 $expected");

    expect($where->bindings())
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

test('where explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c1', '!=', $value)
    )
    ->toBe("c1 != $expected");

    expect($where->bindings())
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

test('where callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where(function (Where $where) use ($column): void {
            $where->where($column);
        })
    )
    ->toBe($expected);

    expect($where->bindings())
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

test('or where single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhere($column)
    )
    ->toBe("(c0 OR $expected)");

    expect($where->bindings())
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

test('or where implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhere('c1', $value)
    )
    ->toBe("(c0 OR c1 $expected)");

    expect($where->bindings())
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

test('or where explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhere('c1', '!=', $value)
    )
    ->toBe("(c0 OR c1 != $expected)");

    expect($where->bindings())
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

test('or where callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhere(function (Where $where) use ($column): void {
            $where->where($column);
        })
    )
    ->toBe("(c0 OR $expected)");

    expect($where->bindings())
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

test('where not single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNot($column)
    )
    ->toBe($expected);

    expect($where->bindings())
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

test('where not implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNot('c1', $value)
    )
    ->toBe("NOT c1 $expected");

    expect($where->bindings())
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

test('where not explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNot('c1', '!=', $value)
    )
    ->toBe("NOT c1 != $expected");

    expect($where->bindings())
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

test('where not callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNot(function (Where $where) use ($column): void {
            $where->where($column);
        })
    )
    ->toBe("NOT $expected");

    expect($where->bindings())
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

test('or where not single column', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNot($column)
    )
    ->toBe("(c0 OR NOT $expected)");

    expect($where->bindings())
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

test('or where not implicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNot('c1', $value)
    )
    ->toBe("(c0 OR NOT c1 $expected)");

    expect($where->bindings())
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

test('or where not explicit operator', function ($value, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNot('c1', '!=', $value)
    )
    ->toBe("(c0 OR NOT c1 != $expected)");

    expect($where->bindings())
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

test('or where not callback', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNot(function (Where $where) use ($column): void {
            $where->where($column);
        })
    )
    ->toBe("(c0 OR NOT $expected)");

    expect($where->bindings())
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

test('where in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereIn($column, ['test', 1])
    )
    ->toBe("$expected IN (?, ?)");

    expect($where->bindings())
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

test('or where in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereIn($column, ['test', 1])
    )
    ->toBe("(c0 OR $expected IN (?, ?))");

    expect($where->bindings())
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

test('where not in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNotIn($column, ['test', 1])
    )
    ->toBe("NOT $expected IN (?, ?)");

    expect($where->bindings())
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

test('or where not in', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNotIn($column, ['test', 1])
    )
    ->toBe("(c0 OR NOT $expected IN (?, ?))");

    expect($where->bindings())
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

test('where between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereBetween($column, 'test', 1)
    )
    ->toBe("$expected BETWEEN ? AND ?");

    expect($where->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or where between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereBetween($column, 'test', 1)
    )
    ->toBe("(c0 OR $expected BETWEEN ? AND ?)");

    expect($where->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('where not between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNotBetween($column, 'test', 1)
    )
    ->toBe("NOT $expected BETWEEN ? AND ?");

    expect($where->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or where not between', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNotBetween($column, 'test', 1)
    )
    ->toBe("(c0 OR NOT $expected BETWEEN ? AND ?)");

    expect($where->bindings())
    ->toBe(array_merge($bindings, ['test', 1]));

})
->with([
    ['c1', 'c1'],
    [1, '?', [1]],
    [1.1, '?', [1.1]],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('where null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNull($column)
    )
    ->toBe("$expected IS NULL");

    expect($where->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or where null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNull($column)
    )
    ->toBe("(c0 OR $expected IS NULL)");

    expect($where->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('where not null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->whereNotNull($column)
    )
    ->toBe("NOT $expected IS NULL");

    expect($where->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);

test('or where not null', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $where = new Where()
        ->where('c0')
        ->orWhereNotNull($column)
    )
    ->toBe("(c0 OR NOT $expected IS NULL)");

    expect($where->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
]);
