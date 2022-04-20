<?php

namespace Zhineng\Bubble\Http;

use PHPUnit\Framework\Assert as PHPUnit;

class Factory
{
    protected bool $recording = false;

    protected array $recorded = [];

    protected function newPendingRequest()
    {
        return new PendingRequest($this);
    }

    public function fake()
    {
        $this->record();

        return $this;
    }

    public function recording(): bool
    {
        return $this->recording;
    }

    public function recordRequestResponsePair(Request $request, Response $response): void
    {
        $this->recorded[] = [$request, $response];
    }

    protected function record(): void
    {
        $this->recording = true;
    }

    public function assertSent(callable $callback)
    {
        PHPUnit::assertTrue(
            $this->count($callback) > 0,
            'The expected request is not being sent.'
        );
    }

    protected function count(callable $callback)
    {
        return count(array_filter($this->recorded, function ($recorded) use ($callback) {
            return $callback($recorded[0], $recorded[1]);
        }));
    }

    public function __call(string $method, array $arguments)
    {
        return $this->newPendingRequest()->{$method}(...$arguments);
    }
}