<?php

namespace Zhineng\Bubble\MiniProgram;

class Auth
{
    public function __construct(
        protected App $app
    ) {}

    public function session(string $code)
    {
        return $this->app->request('GET', '/sns/jscode2session', [
            'query' => [
                'appid' => $this->app->appId(),
                'secret' => $this->app->appSecret(),
                'js_code' => $code,
                'grant_type' => 'authorization_code',
            ],
        ]);
    }

    public function token()
    {
        return $this->app->request('GET', '/cgi-bin/token', [
            'query' => [
                'grant_type' => 'client_credential',
                'appid' => $this->app->appId(),
                'secret' => $this->app->appSecret(),
            ],
        ]);
    }
}
