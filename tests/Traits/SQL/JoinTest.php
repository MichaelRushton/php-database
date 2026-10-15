<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\On;
use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
    ->join($table)
    )
    ->toBe("SELECT * JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a JOIN t2 b'],
]);

test('join using', function ($column, $expected): void {

    expect(
        (string) new SQLiteSelect()
        ->join('t1', $column)
    )
    ->toBe("SELECT * JOIN t1 USING ($expected)");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('join on implicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->join('t1', 'c1', 'c2')
    )
    ->toBe("SELECT * JOIN t1 ON c1 = c2");

});

test('join on explicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->join('t1', 'c1', '!=', 'c2')
    )
    ->toBe("SELECT * JOIN t1 ON c1 != c2");

});

test('join on array', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->join('t1', [
            'c1' => 'c3',
            'c2' => 'c4',
        ])
    )
    ->toBe("SELECT * JOIN t1 ON (c1 = c3 AND c2 = c4)");

});

test('join on closure', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->join('t1', function (On $join): void {
            $join->on('c1');
        })
    )
    ->toBe("SELECT * JOIN t1 ON c1");

});

test('left join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->leftJoin($table)
    )
    ->toBe("SELECT * LEFT JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 LEFT JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a LEFT JOIN t2 b'],
]);

test('left join using', function ($column, $expected): void {

    expect(
        (string) new SQLiteSelect()
        ->leftJoin('t1', $column)
    )
    ->toBe("SELECT * LEFT JOIN t1 USING ($expected)");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('left join on implicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->leftJoin('t1', 'c1', 'c2')
    )
    ->toBe("SELECT * LEFT JOIN t1 ON c1 = c2");

});

test('left join on explicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->leftJoin('t1', 'c1', '!=', 'c2')
    )
    ->toBe("SELECT * LEFT JOIN t1 ON c1 != c2");

});

test('left join on array', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->leftJoin('t1', [
            'c1' => 'c3',
            'c2' => 'c4',
        ])
    )
    ->toBe("SELECT * LEFT JOIN t1 ON (c1 = c3 AND c2 = c4)");

});

test('left join on closure', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->leftJoin('t1', function (On $join): void {
            $join->on('c1');
        })
    )
    ->toBe("SELECT * LEFT JOIN t1 ON c1");

});

test('right join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->rightJoin($table)
    )
    ->toBe("SELECT * RIGHT JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 RIGHT JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a RIGHT JOIN t2 b'],
]);

test('right join using', function ($column, $expected): void {

    expect(
        (string) new SQLiteSelect()
        ->rightJoin('t1', $column)
    )
    ->toBe("SELECT * RIGHT JOIN t1 USING ($expected)");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('right join on implicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->rightJoin('t1', 'c1', 'c2')
    )
    ->toBe("SELECT * RIGHT JOIN t1 ON c1 = c2");

});

test('right join on explicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->rightJoin('t1', 'c1', '!=', 'c2')
    )
    ->toBe("SELECT * RIGHT JOIN t1 ON c1 != c2");

});

test('right join on array', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->rightJoin('t1', [
            'c1' => 'c3',
            'c2' => 'c4',
        ])
    )
    ->toBe("SELECT * RIGHT JOIN t1 ON (c1 = c3 AND c2 = c4)");

});

test('right join on closure', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->rightJoin('t1', function (On $join): void {
            $join->on('c1');
        })
    )
    ->toBe("SELECT * RIGHT JOIN t1 ON c1");

});

test('full join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->fullJoin($table)
    )
    ->toBe("SELECT * FULL JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 FULL JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a FULL JOIN t2 b'],
]);

test('full join using', function ($column, $expected): void {

    expect(
        (string) new SQLiteSelect()
        ->fullJoin('t1', $column)
    )
    ->toBe("SELECT * FULL JOIN t1 USING ($expected)");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('full join on implicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->fullJoin('t1', 'c1', 'c2')
    )
    ->toBe("SELECT * FULL JOIN t1 ON c1 = c2");

});

test('full join on explicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->fullJoin('t1', 'c1', '!=', 'c2')
    )
    ->toBe("SELECT * FULL JOIN t1 ON c1 != c2");

});

test('full join on array', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->fullJoin('t1', [
            'c1' => 'c3',
            'c2' => 'c4',
        ])
    )
    ->toBe("SELECT * FULL JOIN t1 ON (c1 = c3 AND c2 = c4)");

});

test('full join on closure', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->fullJoin('t1', function (On $join): void {
            $join->on('c1');
        })
    )
    ->toBe("SELECT * FULL JOIN t1 ON c1");

});

test('straight join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->straightJoin($table)
    )
    ->toBe("SELECT * STRAIGHT_JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 STRAIGHT_JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a STRAIGHT_JOIN t2 b'],
]);

test('straight join using', function ($column, $expected): void {

    expect(
        (string) new SQLiteSelect()
        ->straightJoin('t1', $column)
    )
    ->toBe("SELECT * STRAIGHT_JOIN t1 USING ($expected)");

})
->with([
    ['c1', 'c1'],
    [['c1', 'c2'], 'c1, c2'],
]);

test('straight join on implicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->straightJoin('t1', 'c1', 'c2')
    )
    ->toBe("SELECT * STRAIGHT_JOIN t1 ON c1 = c2");

});

test('straight join on explicit operator', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->straightJoin('t1', 'c1', '!=', 'c2')
    )
    ->toBe("SELECT * STRAIGHT_JOIN t1 ON c1 != c2");

});

test('straight join on array', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->straightJoin('t1', [
            'c1' => 'c3',
            'c2' => 'c4',
        ])
    )
    ->toBe("SELECT * STRAIGHT_JOIN t1 ON (c1 = c3 AND c2 = c4)");

});

test('straight join on closure', function (): void {

    expect(
        (string) new SQLiteSelect()
        ->straightJoin('t1', function (On $join): void {
            $join->on('c1');
        })
    )
    ->toBe("SELECT * STRAIGHT_JOIN t1 ON c1");

});

test('cross join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->crossJoin($table)
    )
    ->toBe("SELECT * CROSS JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 CROSS JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a CROSS JOIN t2 b'],
]);

test('natural join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->naturalJoin($table)
    )
    ->toBe("SELECT * NATURAL JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 NATURAL JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a NATURAL JOIN t2 b'],
]);

test('natural left join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->naturalLeftJoin($table)
    )
    ->toBe("SELECT * NATURAL LEFT JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 NATURAL LEFT JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a NATURAL LEFT JOIN t2 b'],
]);

test('natural right join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->naturalRightJoin($table)
    )
    ->toBe("SELECT * NATURAL RIGHT JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 NATURAL RIGHT JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a NATURAL RIGHT JOIN t2 b'],
]);

test('natural full join', function ($table, $expected, $bindings = []): void {

    expect(
        (string) $stmt = new SQLiteSelect()
        ->naturalFullJoin($table)
    )
    ->toBe("SELECT * NATURAL FULL JOIN $expected");

    expect($stmt->bindings())
    ->toBe($bindings);

})
->with([
    ['t1', 't1'],
    [new Raw('?', 'test'), '?', ['test']],
    [new SQLiteSelect(), '(SELECT *)'],
    [['t1', 't2'], 't1 NATURAL FULL JOIN t2'],
    [['a' => 't1', 'b' => 't2'], 't1 a NATURAL FULL JOIN t2 b'],
]);
