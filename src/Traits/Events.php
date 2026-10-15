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
use MichaelRushton\Database\Interfaces\EventManagerInterface;

trait Events
{
    protected EventManagerInterface $event_manager;

    public function beforeExec(callable $callback): static
    {

        $this->event_manager->listen(BeforeExecEvent::class, $callback);

        return $this;

    }

    public function afterExec(callable $callback): static
    {

        $this->event_manager->listen(AfterExecEvent::class, $callback);

        return $this;

    }

    public function beforeQuery(callable $callback): static
    {

        $this->event_manager->listen(BeforeQueryEvent::class, $callback);

        return $this;

    }

    public function afterQuery(callable $callback): static
    {

        $this->event_manager->listen(AfterQueryEvent::class, $callback);

        return $this;

    }

    public function beforePrepare(callable $callback): static
    {

        $this->event_manager->listen(BeforePrepareEvent::class, $callback);

        return $this;

    }

    public function afterPrepare(callable $callback): static
    {

        $this->event_manager->listen(AfterPrepareEvent::class, $callback);

        return $this;

    }

    public function beforeBindValue(callable $callback): static
    {

        $this->event_manager->listen(BeforeBindValueEvent::class, $callback);

        return $this;

    }

    public function afterBindValue(callable $callback): static
    {

        $this->event_manager->listen(AfterBindValueEvent::class, $callback);

        return $this;

    }

    public function beforeExecute(callable $callback): static
    {

        $this->event_manager->listen(BeforeExecuteEvent::class, $callback);

        return $this;

    }

    public function afterExecute(callable $callback): static
    {

        $this->event_manager->listen(AfterExecuteEvent::class, $callback);

        return $this;

    }

    public function beforeFetch(callable $callback): static
    {

        $this->event_manager->listen(BeforeFetchEvent::class, $callback);

        return $this;

    }

    public function afterFetch(callable $callback): static
    {

        $this->event_manager->listen(AfterFetchEvent::class, $callback);

        return $this;

    }

    public function beforeFetchAll(callable $callback): static
    {

        $this->event_manager->listen(BeforeFetchAllEvent::class, $callback);

        return $this;

    }

    public function afterFetchAll(callable $callback): static
    {

        $this->event_manager->listen(AfterFetchAllEvent::class, $callback);

        return $this;

    }

    public function beforeFetchColumn(callable $callback): static
    {

        $this->event_manager->listen(BeforeFetchColumnEvent::class, $callback);

        return $this;

    }

    public function afterFetchColumn(callable $callback): static
    {

        $this->event_manager->listen(AfterFetchColumnEvent::class, $callback);

        return $this;

    }

    public function beforeFetchObject(callable $callback): static
    {

        $this->event_manager->listen(BeforeFetchObjectEvent::class, $callback);

        return $this;

    }

    public function afterFetchObject(callable $callback): static
    {

        $this->event_manager->listen(AfterFetchObjectEvent::class, $callback);

        return $this;

    }
}
