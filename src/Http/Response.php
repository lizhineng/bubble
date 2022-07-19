<?php

namespace Zhineng\Bubble\Http;

use Psr\Http\Message\ResponseInterface;
use Zhineng\Bubble\Support\Arr;

class Response
{
    protected ?array $decoded = null;

    public function __construct(
        protected ResponseInterface $response
    ) {
        //
    }

    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    public function ok(): bool
    {
        return $this->status() === 200;
    }

    public function successful(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    public function redirect(): bool
    {
        return $this->status() >= 300 && $this->status() < 400;
    }

    public function clientError(): bool
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    public function serverError(): bool
    {
        return $this->status() >= 500 && $this->status() < 600;
    }

    public function failed(): bool
    {
        return $this->clientError() || $this->serverError();
    }

    public function body(): string
    {
        return $this->response->getBody();
    }

    public function json($key = null, $default = null)
    {
        if (! $this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        return Arr::get($this->decoded, $key, $default);
    }

    public function toPsrResponse(): ResponseInterface
    {
        return $this->response;
    }
}
