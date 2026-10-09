<?php

declare(strict_types=1);

use MichaelRushton\Database\SQL\Components\Table;

test('for portion of', function ($start, $end): void {

    expect(
        (string) new Table('t1')
        ->forPortionOf('date_period', $start, $end)
    )
    ->toBe("t1 FOR PORTION OF date_period FROM '2024-01-01 00:00:00' TO '2025-01-01 00:00:00'");

})
->with([
    ['2024-01-01 00:00:00', '2025-01-01 00:00:00'],
    [new DateTime('2024-01-01 00:00:00'), new DateTime('2025-01-01 00:00:00')],
]);
