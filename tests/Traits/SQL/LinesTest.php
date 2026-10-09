<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Outfile;

test('lines starting by', function ($string, $output): void {

    expect((string) new Outfile('path')->linesStartingBy($string))
    ->toBe("'path' LINES STARTING BY '$output'");

})
->with([
    [":", ":"],
    ["'", "''"],
]);

test('lines terminated by', function ($string, $output): void {

    expect((string) new Outfile('path')->linesTerminatedBy($string))
    ->toBe("'path' LINES TERMINATED BY '$output'");

})
->with([
    ['\n', '\n'],
    ["'", "''"],
]);

test('lines', function (): void {

    expect(
        (string) new Outfile('path')
        ->linesStartingBy(":")
        ->linesTerminatedBy('\n')
    )
    ->toBe('\'path\' LINES STARTING BY \':\' TERMINATED BY \'\n\'');

});
