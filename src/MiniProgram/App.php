<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\ManagesHttp;
use Zhineng\Bubble\Contracts\ApiClient;
use Zhineng\Bubble\MiniProgram\Concerns\HasAbilities;
use Zhineng\Bubble\MiniProgram\Concerns\HasCache;

class App implements ApiClient
{
    use ManagesHttp, HasAbilities, HasCache;

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

    public function apiEndpoint(): string
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
            return $this->resolveToken();
        }

        return $this->cache()->remember($this->cacheKeyFor('token'), 7200, function () {
            return $this->resolveToken();
        });
    }

    public function resolveToken(): string
    {
        return $this->ability('auth')
            ->token()
            ->json('access_token');
    }
}
