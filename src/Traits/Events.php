<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits;

use MichaelRushton\Database\Events\AfterBindValueEvent;
use MichaelRushton\Database\Events\AfterExecEvent;
use MichaelRushton\Database\Events\AfterExecuteEvent;
use MichaelRushton\Database\Events\AfterFetchAllEvent;
use MichaelRushton\Database\Events\AfterFetchColumnEvent;
use MichaelRushton\Database\Events\AfterFetchEvent;
use MichaelRushton\Database\Events\AfterFetchObjectEvent;
use MichaelRushton\Database\Events\AfterPrepareEvent;
use MichaelRushton\Database\Events\AfterQueryEvent;
use MichaelRushton\Database\Events\BeforeBindValueEvent;
use MichaelRushton\Database\Events\BeforeExecEvent;
use MichaelRushton\Database\Events\BeforeExecuteEvent;
use MichaelRushton\Database\Events\BeforeFetchAllEvent;
use MichaelRushton\Database\Events\BeforeFetchColumnEvent;
use MichaelRushton\Database\Events\BeforeFetchEvent;
use MichaelRushton\Database\Events\BeforeFetchObjectEvent;
use MichaelRushton\Database\Events\BeforePrepareEvent;
use MichaelRushton\Database\Events\BeforeQueryEvent;

trait Events
{
    protected array $events = [];

    public function listen(
        string $event,
        callable $callback
    ): static {

        $this->events[$event][] = $callback;

        return $this;

    }

    public function dispatch(object $event): void
    {

        foreach ($this->events[$event::class] ?? [] as $callback) {
            $callback($event);
        }

    }

    public function beforeExec(callable $callback): static
    {
        return $this->listen(BeforeExecEvent::class, $callback);
    }

    public function afterExec(callable $callback): static
    {
        return $this->listen(AfterExecEvent::class, $callback);
    }

    public function beforeQuery(callable $callback): static
    {
        return $this->listen(BeforeQueryEvent::class, $callback);
    }

    public function afterQuery(callable $callback): static
    {
        return $this->listen(AfterQueryEvent::class, $callback);
    }

    public function beforePrepare(callable $callback): static
    {
        return $this->listen(BeforePrepareEvent::class, $callback);
    }

    public function afterPrepare(callable $callback): static
    {
        return $this->listen(AfterPrepareEvent::class, $callback);
    }

    public function beforeBindValue(callable $callback): static
    {
        return $this->listen(BeforeBindValueEvent::class, $callback);
    }

    public function afterBindValue(callable $callback): static
    {
        return $this->listen(AfterBindValueEvent::class, $callback);
    }

    public function beforeExecute(callable $callback): static
    {
        return $this->listen(BeforeExecuteEvent::class, $callback);
    }

    public function afterExecute(callable $callback): static
    {
        return $this->listen(AfterExecuteEvent::class, $callback);
    }

    public function beforeFetch(callable $callback): static
    {
        return $this->listen(BeforeFetchEvent::class, $callback);
    }

    public function afterFetch(callable $callback): static
    {
        return $this->listen(AfterFetchEvent::class, $callback);
    }

    public function beforeFetchAll(callable $callback): static
    {
        return $this->listen(BeforeFetchAllEvent::class, $callback);
    }

    public function afterFetchAll(callable $callback): static
    {
        return $this->listen(AfterFetchAllEvent::class, $callback);
    }

    public function beforeFetchColumn(callable $callback): static
    {
        return $this->listen(BeforeFetchColumnEvent::class, $callback);
    }

    public function afterFetchColumn(callable $callback): static
    {
        return $this->listen(AfterFetchColumnEvent::class, $callback);
    }

    public function beforeFetchObject(callable $callback): static
    {
        return $this->listen(BeforeFetchObjectEvent::class, $callback);
    }

    public function afterFetchObject(callable $callback): static
    {
        return $this->listen(AfterFetchObjectEvent::class, $callback);
    }
}
