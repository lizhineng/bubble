<?php

namespace Zhineng\Bubble\Work;

use GuzzleHttp\Client;
use Zhineng\Bubble\Support\Response;
use Zhineng\Bubble\Work\Messages\Message;

class Robot
{
    public function __construct(
        protected string $key
    ) {}

    public function key(): string
    {
        return $this->key;
    }

    public function sendRaw(array $payload): Response
    {
        return $this->request('POST', '/cgi-bin/webhook/send', [
            'query' => [
                'key' => $this->key(),
            ],
            'json' => $payload,
        ]);
    }

    public function send(Message $message): Response
    {
        return $this->sendRaw([
            'msgtype' => $message->type(),
            $message->type() => $message->payload(),
        ]);
    }

    public function request(string $method, $uri = '', array $options = []): Response
    {
        $response = $this->client()->request($method, $uri, $options);

        return new Response($response);
    }

    public function client(): Client
    {
        return new Client([
            'base_uri' => 'https://qyapi.weixin.qq.com',
            'timeout' => 2.0,
        ]);
    }
}
