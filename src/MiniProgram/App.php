<?php

namespace Zhineng\Bubble\MiniProgram;

use GuzzleHttp\Client;
use Zhineng\Bubble\Support\Response;

class App
{
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
        return 'foo';
    }

    public function request(string $method, $uri = '', array $options = []): Response
    {
        $response = $this->client()->request($method, $uri, $options);

        return new Response($response);
    }

    public function client(): Client
    {
        return new Client([
            'base_uri' => 'https://api.weixin.qq.com',
            'timeout' => 2.0,
        ]);
    }
}
