<?php

namespace Zhineng\Bubble\Http;

use ArrayAccess;
use LogicException;
use Psr\Http\Message\RequestInterface;

class Request implements ArrayAccess
{
    public function __construct(
        protected RequestInterface $request
    ) {
        //
    }

    public function method(): string
    {
        return $this->request->getMethod();
    }

    public function url(): string
    {
        return $this->request->getUri();
    }

    public function data()
    {
        return json_decode(((string) $this->request->getBody()), associative: true);
    }

    public function offsetExists($offset): bool
    {
        return $this->data()[$offset] ?? false;
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data()[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Could not mutate request data.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Could not mutate request data.');
    }
}