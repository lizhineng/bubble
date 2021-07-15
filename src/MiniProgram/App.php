<?php

namespace Zhineng\Bubble\MiniProgram;

use GuzzleHttp\Client;
use Zhineng\Bubble\MiniProgram\Concerns\HasAbilities;
use Zhineng\Bubble\MiniProgram\Concerns\HasCache;
use Zhineng\Bubble\Support\Response;

class App
{
    use HasAbilities, HasCache;

    /**
     * The Guzzle client instance.
     *
     * @var Client
     */
    protected Client $client;

    public function __construct(
        protected string $appId,
        protected string $appSecret
    ) {}

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
        $response = $this->ability('auth')->token();

        if (! $this->hasCache()) {
            return $response->json('access_token');
        }

        return $this->cache()->remember(
            $this->cacheKeyFor('token'), $response->json('expires_in'), fn () => $response->json('access_token')
        );
    }

    public function request(string $method, $uri = '', array $options = []): Response
    {
        $response = $this->client()->request($method, $uri, $options);

        return new Response($response);
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
}
