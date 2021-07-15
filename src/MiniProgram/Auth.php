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

    /**
     * Retrieve access token for calling backend APIs.
     *
     * @return \Zhineng\Bubble\Support\Response
     * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/access-token/auth.getAccessToken.html
     */
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
