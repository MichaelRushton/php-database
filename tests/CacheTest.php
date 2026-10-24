<?php

declare(strict_types=1);

use MichaelRushton\Database\Cache;
use MichaelRushton\Database\Connections\SQLiteConnection;
use MichaelRushton\Database\Interfaces\CacheInterface;

test('implements cache interface', function (): void {

    expect(new Cache())
    ->toBeInstanceOf(CacheInterface::class);

});

test('key', function (): void {

    expect(new Cache()->key('test'))
    ->toBe(hash('xxh128', 'test'));

});

test('set and get', function (): void {

    $cache = new Cache();

    expect($cache->get('test'))
    ->toBeNull();

    $stmt1 = new SQLiteConnection()->prepare("SELECT 1");
    $stmt2 = new SQLiteConnection()->prepare("SELECT 2");

    $cache->set('test1', $stmt1);
    $cache->set('test2', $stmt2);

    expect($cache->get('test1'))
    ->toBe($stmt1);

    expect($cache->get('test2'))
    ->toBe($stmt2);

});

test('clear', function (): void {

    $cache = new Cache();

    $stmt1 = new SQLiteConnection()->prepare("SELECT 1");
    $stmt2 = new SQLiteConnection()->prepare("SELECT 2");

    $cache->set('test1', $stmt1);
    $cache->set('test2', $stmt2);

    $cache->clear();

    expect($cache->get('test1'))
    ->toBeNull();

    expect($cache->get('test2'))
    ->toBeNull();

});
