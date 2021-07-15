<?php

namespace Zhineng\Bubble\Support;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * The decoded JSON response.
     *
     * @var array
     */
    protected array $decoded = [];

    public function __construct(
        protected ResponseInterface $response
    ) {}

    public function body(): string
    {
        return $this->response->getBody();
    }

    public function json(string $key = null, $default = null)
    {
        if (! $this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return data_get($this->decoded, $key, $default);
    }

    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    public function successful(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    public function ok(): bool
    {
        return $this->status() === 200;
    }

    public function failed(): bool
    {
        return $this->clientError() || $this->serverError();
    }

    public function clientError(): bool
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    public function serverError(): bool
    {
        return $this->status() >= 500;
    }

    public function raw(): ResponseInterface
    {
        return $this->response;
    }

    public function __toString(): string
    {
        return $this->body();
    }
}
