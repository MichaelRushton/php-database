<?php

declare(strict_types=1);

use MichaelRushton\Database\EventManager;
use MichaelRushton\Database\Events\Event;
use MichaelRushton\Database\Interfaces\EventManagerInterface;

test('implements event manager interface', function (): void {

    expect(new EventManager())
    ->toBeInstanceOf(EventManagerInterface::class);

});

test('listen and dispatch', function (): void {

    $event_manager = new EventManager();

    class EventManagerEvent1 extends Event {}
    class EventManagerEvent2 extends Event {}

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

    expect($event_manager->dispatch($event1))
    ->toBe($event_manager);

    expect($events)
    ->toBe([$event1, $event1]);

    $event_manager->dispatch($event2);

    expect($events)
    ->toBe([$event1, $event1, $event2]);

});

test('throws exception if event name is not a class', function (): void {
    new EventManager()->listen('test', fn() => null);
})
->throws(InvalidArgumentException::class);
