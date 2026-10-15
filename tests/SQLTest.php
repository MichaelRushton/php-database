<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL;
use MichaelRushton\Database\SQL\Components\Raw;
use MichaelRushton\Database\SQL\Components\Subquery;
use MichaelRushton\Database\SQL\Statements\SQLite\SQLiteSelect;

test('string identifier', function (): void {

    expect(SQL::identifier('test'))
    ->toBe('test');

});

test('scalar identifier', function ($value): void {

    expect($raw = SQL::identifier($value))
    ->toBeInstanceOf(Raw::class);

    expect("$raw")
    ->toBe('?');

    expect($raw->bindings())
    ->toBe([$value]);

})
->with([1, 1.1, true, null]);

test('stringable identifier', function (): void {

    expect(SQL::identifier($raw = new Raw('')))
    ->toBe($raw);

});

test('subquery identifier', function (): void {

    expect($raw = SQL::identifier(new SQLiteSelect()))
    ->toBeInstanceOf(Subquery::class);

    expect("$raw")
    ->toBe('(SELECT *)');

});

test('array identifier', function (): void {

    expect($values = SQL::identifier([0, 1]))
    ->toBeArray()
    ->toHaveCount(2);

    foreach ($values as $key => $value) {

        expect($value)
        ->toBeInstanceOf(Raw::class);

        expect("$value")
        ->toBe('?');

        expect($value->bindings())
        ->toBe([$key]);

    }

});

test('scalar value', function ($value): void {

    expect($raw = SQL::value($value))
    ->toBeInstanceOf(Raw::class);

    expect("$raw")
    ->toBe('?');

    expect($raw->bindings())
    ->toBe([$value]);

})
->with(['test', 1, 1.1, true, null]);

test('stringable value', function (): void {

    expect(SQL::value($raw = new Raw('')))
    ->toBe($raw);

});

test('subquery value', function (): void {

    expect($raw = SQL::value(new SQLiteSelect()))
    ->toBeInstanceOf(Subquery::class);

    expect("$raw")
    ->toBe('(SELECT *)');

});

test('array value', function (): void {

    expect($values = SQL::value([0, 1]))
    ->toBeArray()
    ->toHaveCount(2);

    foreach ($values as $key => $value) {

        expect($value)
        ->toBeInstanceOf(Raw::class);

        expect("$value")
        ->toBe('?');

        expect($value->bindings())
        ->toBe([$key]);

    }

});

test('bind', function ($value): void {

    expect($raw = SQL::bind($value))
    ->toBeInstanceOf(Raw::class);

    expect("$raw")
    ->toBe('?');

    expect($raw->bindings())
    ->toBe([$value]);

})
->with(['test', 1, 1.1, true, null]);

test('escape', function (): void {

    expect(SQL::escape("this is a 'test'"))
    ->toBe("this is a ''test''");

});
