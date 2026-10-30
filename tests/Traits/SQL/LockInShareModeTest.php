<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Statements\MariaDB\MariaDBSelect;

test('lock in share mode', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->lockInShareMode()
    )
    ->toBe("SELECT * LOCK IN SHARE MODE");

});

test('lock in share mode wait', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->lockInShareModeWait(1)
    )
    ->toBe("SELECT * LOCK IN SHARE MODE WAIT 1");

});

test('lock in share mode nowait', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->lockInShareModeNoWait()
    )
    ->toBe("SELECT * LOCK IN SHARE MODE NOWAIT");

});

test('lock in share mode skip locked', function (): void {

    expect(
        (string) new MariaDBSelect()
        ->lockInShareModeSkipLocked()
    )
    ->toBe("SELECT * LOCK IN SHARE MODE SKIP LOCKED");

});
