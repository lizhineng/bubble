<?php

namespace Zhineng\Bubble\Http;

class Factory
{
    protected bool $recording = false;

    protected function newPendingRequest()
    {
        return new PendingRequest;
    }

    public function fake(): void
    {
        $this->record();
    }

    protected function record(): void
    {
        $this->recording = true;
    }

    public function assertSent(callable $callback)
    {
        return true;
    }

    public function __call(string $method, array $arguments)
    {
        return $this->newPendingRequest()->{$method}(...$arguments);
    }
}