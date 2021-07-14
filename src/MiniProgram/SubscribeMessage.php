<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Support\Response;

class SubscribeMessage
{
    public function __construct(
        protected App $app
    ) {}

    public function send(array $data): Response
    {
        return $this->app->request('POST', '/cgi-bin/message/subscribe/send', [
            'query' => [
                'access_token' => $this->app->token(),
            ],
            'json' => $data,
        ]);
    }
}
