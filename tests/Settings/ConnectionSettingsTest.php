<?php

declare(strict_types=1);

use MichaelRushton\Database\Interfaces\Settings\ConnectionSettingsInterface;
use MichaelRushton\Database\Settings\ConnectionSettings;

test('implements connection settings interface', function (): void {

    expect(new ConnectionSettings())
    ->toBeInstanceOf(ConnectionSettingsInterface::class);

});

test('get and set cache prepared statements', function ($enabled): void {

    $settings = new ConnectionSettings();

    expect($settings->getCachePreparedStatements())
    ->toBeTrue();

    $settings->setCachePreparedStatements($enabled);

    expect($settings->getCachePreparedStatements())
    ->toBe($enabled);

})
->with([true, false]);
