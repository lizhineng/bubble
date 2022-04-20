<?php

namespace Zhineng\Bubble\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PendingRequest
{
    protected string $baseUrl = '';

    public function __construct(
        protected ?Factory $factory = null
    ) {
        //
    }

    public function baseUrl(string $url)
    {
        $this->baseUrl = $url;

        return $this;
    }

    public function get(string $url, $query = [])
    {
        $url = $this->baseUrl.$url;

        return new Response($this->buildClient($this->configureHandler($this->buildHandler()))
            ->get($url, compact('query')));
    }

    public function post(string $url, $data = [])
    {
        $url = $this->baseUrl.$url;

        return new Response($this->buildClient($this->configureHandler($this->buildHandler()))
            ->post($url, ['json' => $data]));
    }

    public function buildClient($handler): Client
    {
        return new Client(['handler' => $handler]);
    }

    protected function buildHandler()
    {
        return HandlerStack::create();
    }

    protected function configureHandler(HandlerStack $stack)
    {
        $stack->push($this->buildRecordHandler());
        $stack->push($this->buildStubHandler());

        return $stack;
    }

    protected function buildRecordHandler(): callable
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $promise = $handler($request, $options);

                return $promise->then(function (ResponseInterface $response) use ($request) {
                    if ($this->factory?->recording()) {
                        $this->factory->recordRequestResponsePair(new Request($request), new Response($response));
                    }

                    return $response;
                });
            };
        };
    }

    protected function buildStubHandler(): callable
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->factory?->recording()) {
                    $response = new \GuzzleHttp\Psr7\Response();

                    return Create::promiseFor($response);
                }

                return $handler($request, $options);
            };
        };
    }
}