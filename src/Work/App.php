<?php

namespace Zhineng\Bubble\Work;

use Zhineng\Bubble\Contracts\ApiClient;

class App implements ApiClient
{
    public function __construct(
        protected string $corpId,
        protected string $corpSecret,
    ) {
        //
    }

    public function corpId(): string
    {
        return $this->corpId;
    }

    public function corpSecret(): string
    {
        return $this->corpSecret;
    }

    public function apiEndpoint(): string
    {
        return 'https://qyapi.weixin.qq.com';
    }
}