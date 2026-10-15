<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Window;

test('range', function (): void {

    expect(
        (string) new Window('w1')
        ->range()
    )
    ->toBe('w1 AS (RANGE)');

});

test('rows', function (): void {

    expect(
        (string) new Window('w1')
        ->rows()
    )
    ->toBe('w1 AS (ROWS)');

});

test('groups', function (): void {

    expect(
        (string) new Window('w1')
        ->groups()
    )
    ->toBe('w1 AS (GROUPS)');

});

test('current row', function (): void {

    expect(
        (string) new Window('w1')
        ->currentRow()
    )
    ->toBe('w1 AS (CURRENT ROW)');

});

test('unbounded preceding', function (): void {

    expect(
        (string) new Window('w1')
        ->unboundedPreceding()
    )
    ->toBe('w1 AS (UNBOUNDED PRECEDING)');

});

test('unbounded following', function (): void {

    expect(
        (string) new Window('w1')
        ->unboundedFollowing()
    )
    ->toBe('w1 AS (UNBOUNDED FOLLOWING)');

});

test('preceding', function ($expression, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->preceding($expression)
    )
    ->toBe("w1 AS ($expected PRECEDING)");

    expect(
        $window->bindings()
    )
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('following', function ($expression, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->following($expression)
    )
    ->toBe("w1 AS ($expected FOLLOWING)");

    expect(
        $window->bindings()
    )
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('between current row', function (): void {

    expect(
        (string) new Window('w1')
        ->betweenCurrentRow()
    )
    ->toBe('w1 AS (BETWEEN CURRENT ROW)');

});

test('between unbounded preceding', function (): void {

    expect(
        (string) new Window('w1')
        ->betweenUnboundedPreceding()
    )
    ->toBe('w1 AS (BETWEEN UNBOUNDED PRECEDING)');

});

test('between unbounded following', function (): void {

    expect(
        (string) new Window('w1')
        ->betweenUnboundedFollowing()
    )
    ->toBe('w1 AS (BETWEEN UNBOUNDED FOLLOWING)');

});

test('between preceding', function ($expression, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->betweenPreceding($expression)
    )
    ->toBe("w1 AS (BETWEEN $expected PRECEDING)");

    expect(
        $window->bindings()
    )
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('between following', function ($expression, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->betweenFollowing($expression)
    )
    ->toBe("w1 AS (BETWEEN $expected FOLLOWING)");

    expect(
        $window->bindings()
    )
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('and current row', function (): void {

    expect(
        (string) new Window('w1')
        ->andCurrentRow()
    )
    ->toBe('w1 AS (AND CURRENT ROW)');

});

test('and unbounded preceding', function (): void {

    expect(
        (string) new Window('w1')
        ->andUnboundedPreceding()
    )
    ->toBe('w1 AS (AND UNBOUNDED PRECEDING)');

});

test('and unbounded following', function (): void {

    expect(
        (string) new Window('w1')
        ->andUnboundedFollowing()
    )
    ->toBe('w1 AS (AND UNBOUNDED FOLLOWING)');

});

test('and preceding', function ($expression, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->andPreceding($expression)
    )
    ->toBe("w1 AS (AND $expected PRECEDING)");

    expect(
        $window->bindings()
    )
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('and following', function ($expression, $expected, $bindings = []): void {

    expect(
        (string) $window = new Window('w1')
        ->andFollowing($expression)
    )
    ->toBe("w1 AS (AND $expected FOLLOWING)");

    expect(
        $window->bindings()
    )
    ->toBe($bindings);

})
->with([
    [1, '1'],
    ['test', 'test'],
    [new Raw('?', 1), '?', [1]],
]);

test('exclude current row', function (): void {

    expect(
        (string) new Window('w1')
        ->excludeCurrentRow()
    )
    ->toBe('w1 AS (EXCLUDE CURRENT ROW)');

});

test('exclude group', function (): void {

    expect(
        (string) new Window('w1')
        ->excludeGroup()
    )
    ->toBe('w1 AS (EXCLUDE GROUP)');

});

test('exclude no others', function (): void {

    expect(
        (string) new Window('w1')
        ->excludeNoOthers()
    )
    ->toBe('w1 AS (EXCLUDE NO OTHERS)');

});

test('exclude ties', function (): void {

    expect(
        (string) new Window('w1')
        ->excludeTies()
    )
    ->toBe('w1 AS (EXCLUDE TIES)');

});

test('frame spec', function (): void {

    expect(
        (string) new Window('w1')
        ->range()
        ->betweenCurrentRow()
        ->andCurrentRow()
        ->excludeCurrentRow()
    )
    ->toBe('w1 AS (RANGE BETWEEN CURRENT ROW AND CURRENT ROW EXCLUDE CURRENT ROW)');

});
