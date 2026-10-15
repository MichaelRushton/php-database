<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('order by', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->orderBy($column)
    )
    ->toBe("SELECT * ORDER BY $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c2'], 'c1, c2'],
]);

test('order by spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->orderBy('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("SELECT * ORDER BY c1, c2, c3, c4");

});

test('order by desc', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->orderByDesc($column)
    )
    ->toBe("SELECT * ORDER BY $expected DESC");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c2'], 'c1 DESC, c2'],
]);

test('order by desc spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->orderByDesc('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("SELECT * ORDER BY c1 DESC, c2 DESC, c3 DESC, c4 DESC");

});

test('order by nulls first', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->orderByNullsFirst($column)
    )
    ->toBe("SELECT * ORDER BY $expected ASC NULLS FIRST");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c2'], 'c1 ASC NULLS FIRST, c2'],
]);

test('order by nulls first spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->orderByNullsFirst('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("SELECT * ORDER BY c1 ASC NULLS FIRST, c2 ASC NULLS FIRST, c3 ASC NULLS FIRST, c4 ASC NULLS FIRST");

});

test('order by nulls last', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->orderByNullsLast($column)
    )
    ->toBe("SELECT * ORDER BY $expected ASC NULLS LAST");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c2'], 'c1 ASC NULLS LAST, c2'],
]);

test('order by nulls last spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->orderByNullsLast('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("SELECT * ORDER BY c1 ASC NULLS LAST, c2 ASC NULLS LAST, c3 ASC NULLS LAST, c4 ASC NULLS LAST");

});

test('order by desc nulls first', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->orderByDescNullsFirst($column)
    )
    ->toBe("SELECT * ORDER BY $expected DESC NULLS FIRST");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c2'], 'c1 DESC NULLS FIRST, c2'],
]);

test('order by desc nulls first spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->orderByDescNullsFirst('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("SELECT * ORDER BY c1 DESC NULLS FIRST, c2 DESC NULLS FIRST, c3 DESC NULLS FIRST, c4 DESC NULLS FIRST");

});

test('order by desc nulls last', function ($column, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->orderByDescNullsLast($column)
    )
    ->toBe("SELECT * ORDER BY $expected DESC NULLS LAST");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['c1', 'c1'],
    [new SQLiteSelect()->columns(1), '(SELECT ?)', [1]],
    [['c1', 'c2'], 'c1 DESC NULLS LAST, c2'],
]);

test('order by desc nulls last spread', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->orderByDescNullsLast('c1', 'c2', ['c3', 'c4'])
    )
    ->toBe("SELECT * ORDER BY c1 DESC NULLS LAST, c2 DESC NULLS LAST, c3 DESC NULLS LAST, c4 DESC NULLS LAST");

});
