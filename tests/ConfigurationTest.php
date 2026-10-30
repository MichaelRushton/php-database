<?php

declare(strict_types=1);

use MichaelRushton\Database\Configuration;
use MichaelRushton\Database\Interfaces\ConfigurationInterface;

test('implements connection configuration interface', function (): void {

    expect(new Configuration())
    ->toBeInstanceOf(ConfigurationInterface::class);

});

test('get and set cache prepared statements', function ($enabled): void {

    $configuration = new Configuration();

    expect($configuration->cache_prepared_statements)
    ->toBeTrue();

    $configuration->cache_prepared_statements = $enabled;

    expect($configuration->cache_prepared_statements)
    ->toBe($enabled);

})
->with([true, false]);
