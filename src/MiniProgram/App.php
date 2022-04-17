<?php

namespace Zhineng\Bubble\MiniProgram;

use BadMethodCallException;
use GuzzleHttp\Client;
use Zhineng\Bubble\Contracts\CommunicateWithApi;
use Zhineng\Bubble\Http\Factory;
use Zhineng\Bubble\MiniProgram\Concerns\HasAbilities;
use Zhineng\Bubble\MiniProgram\Concerns\HasCache;
use Zhineng\Bubble\Support\Response;

class App implements CommunicateWithApi
{
    use HasAbilities, HasCache;

    /**
     * The Guzzle client instance.
     *
     * @var Client|null
     */
    protected ?Client $client = null;

    protected ?Factory $http = null;

    public function __construct(
        protected string $appId,
        protected string $appSecret
    ) {
        //
    }

    public static function make(string $appId, string $appSecret)
    {
        return new static($appId, $appSecret);
    }

    public function endpoint(): string
    {
        return 'https://api.weixin.qq.com';
    }

    public function appId(): string
    {
        return $this->appId;
    }

    public function appSecret(): string
    {
        return $this->appSecret;
    }

    public function token(): string
    {
        if (! $this->hasCache()) {
            $response = $this->ability('auth')->token();

            return $response->json('access_token');
        }

        return $this->cache()->remember($this->cacheKeyFor('token'), 7200, function () {
            $response = $this->ability('auth')->token();

            return $response->json('access_token');
        });
    }

    public function request(string $method, $uri = '', array $options = []): Response
    {
        $response = $this->client()->request($method, $uri, $options);

        return new Response($response);
    }

    public function http()
    {
        return $this->http = $this->http ?: new Factory;
    }

    public function httpUsing($factory)
    {
        $this->http = $factory;

        return $this;
    }

    public function client(): Client
    {
        return $this->client = $this->client ?: new Client([
            'base_uri' => 'https://api.weixin.qq.com',
            'timeout' => 2.0,
        ]);
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function __call(string $method, array $parameters)
    {
        if ($this->hasAbility($method)) {
            return $this->$method;
        }

        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()', static::class, $method
        ));
    }
}
