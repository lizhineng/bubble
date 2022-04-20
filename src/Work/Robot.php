<?php

namespace Zhineng\Bubble\Work;

use GuzzleHttp\Client;
use Zhineng\Bubble\Contracts\ApiClient;
use Zhineng\Bubble\ManagesHttp;
use Zhineng\Bubble\Work\Contracts\Message;

class Robot implements ApiClient
{
    use ManagesHttp;

    public function __construct(
        protected string $key
    ) {
        //
    }

    public function key(): string
    {
        return $this->key;
    }

    public function apiEndpoint(): string
    {
        return 'https://qyapi.weixin.qq.com';
    }

    public function sendRaw(array $data)
    {
        return $this->newRequest()->post('/cgi-bin/webhook/send?key='.$this->key, $data);
    }

    public function send(Message $message)
    {
        return $this->sendRaw([
            'msgtype' => $message->type(),
            $message->type() => $message->payload(),
        ]);
    }
}
