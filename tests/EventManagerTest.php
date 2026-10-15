<?php

declare(strict_types=1);

use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Interfaces\EventManagerInterface;

test('implements event manager interface', function (): void {

    expect(new EventManager())
    ->toBeInstanceOf(EventManagerInterface::class);

});

test('listen and dispatch', function (): void {

    $event_manager = new EventManager();

    class EventManagerEvent1 {}
    class EventManagerEvent2 {}

    $events = [];

    expect($event_manager->listen(EventManagerEvent1::class, function (EventManagerEvent1 $event) use (&$events): void {
        $events[] = $event;
    }))
    ->toBe($event_manager);

    $event_manager->listen(EventManagerEvent1::class, function (EventManagerEvent1 $event) use (&$events): void {
        $events[] = $event;
    });

    $event_manager->listen(EventManagerEvent2::class, function (EventManagerEvent2 $event) use (&$events): void {
        $events[] = $event;
    });

    $event1 = new EventManagerEvent1();
    $event2 = new EventManagerEvent2();

    $event_manager->dispatch($event1);

    expect($events)
    ->toBe([$event1, $event1]);

    $event_manager->dispatch($event2);

    expect($events)
    ->toBe([$event1, $event1, $event2]);

});
