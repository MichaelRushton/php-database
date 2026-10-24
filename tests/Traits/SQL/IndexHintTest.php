<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Table;

test('use index', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->useIndex($index)
    )
    ->toBe("t1 USE INDEX ($expected)");

})
->with([
    [null, ''],
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('use index spread', function (): void {

    expect(
        (string) new Table('t1')
        ->useIndex('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 USE INDEX (i1, i2, i3, i4)");

});

test('use index for order by', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->useIndexForOrderBy($index)
    )
    ->toBe("t1 USE INDEX FOR ORDER BY ($expected)");

})
->with([
    [null, ''],
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('use index for order by spread', function (): void {

    expect(
        (string) new Table('t1')
        ->useIndexForOrderBy('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 USE INDEX FOR ORDER BY (i1, i2, i3, i4)");

});

test('use index for group by', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->useIndexForGroupBy($index)
    )
    ->toBe("t1 USE INDEX FOR GROUP BY ($expected)");

})
->with([
    [null, ''],
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('use index for group by spread', function (): void {

    expect(
        (string) new Table('t1')
        ->useIndexForGroupBy('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 USE INDEX FOR GROUP BY (i1, i2, i3, i4)");

});

test('ignore index', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->ignoreIndex($index)
    )
    ->toBe("t1 IGNORE INDEX ($expected)");

})
->with([
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('ignore index spread', function (): void {

    expect(
        (string) new Table('t1')
        ->ignoreIndex('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 IGNORE INDEX (i1, i2, i3, i4)");

});

test('ignore index for order by', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->ignoreIndexForOrderBy($index)
    )
    ->toBe("t1 IGNORE INDEX FOR ORDER BY ($expected)");

})
->with([
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('ignore index for order by spread', function (): void {

    expect(
        (string) new Table('t1')
        ->ignoreIndexForOrderBy('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 IGNORE INDEX FOR ORDER BY (i1, i2, i3, i4)");

});

test('ignore index for group by', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->ignoreIndexForGroupBy($index)
    )
    ->toBe("t1 IGNORE INDEX FOR GROUP BY ($expected)");

})
->with([
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('ignore index for group by spread', function (): void {

    expect(
        (string) new Table('t1')
        ->ignoreIndexForGroupBy('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 IGNORE INDEX FOR GROUP BY (i1, i2, i3, i4)");

});

test('force index', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->forceIndex($index)
    )
    ->toBe("t1 FORCE INDEX ($expected)");

})
->with([
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('force index spread', function (): void {

    expect(
        (string) new Table('t1')
        ->forceIndex('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 FORCE INDEX (i1, i2, i3, i4)");

});

test('force index for order by', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->forceIndexForOrderBy($index)
    )
    ->toBe("t1 FORCE INDEX FOR ORDER BY ($expected)");

})
->with([
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('force index for order by spread', function (): void {

    expect(
        (string) new Table('t1')
        ->forceIndexForOrderBy('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 FORCE INDEX FOR ORDER BY (i1, i2, i3, i4)");

});

test('force index for group by', function ($index, $expected): void {

    expect(
        (string) new Table('t1')
        ->forceIndexForGroupBy($index)
    )
    ->toBe("t1 FORCE INDEX FOR GROUP BY ($expected)");

})
->with([
    ['i1', 'i1'],
    [['i1', 'i2'], 'i1, i2'],
]);

test('force index for group by spread', function (): void {

    expect(
        (string) new Table('t1')
        ->forceIndexForGroupBy('i1', 'i2', ['i3', 'i4'])
    )
    ->toBe("t1 FORCE INDEX FOR GROUP BY (i1, i2, i3, i4)");

});
