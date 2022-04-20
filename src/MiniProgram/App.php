<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Contracts\CommunicateWithApi;
use Zhineng\Bubble\Http\Factory;
use Zhineng\Bubble\Http\PendingRequest;
use Zhineng\Bubble\MiniProgram\Concerns\HasAbilities;
use Zhineng\Bubble\MiniProgram\Concerns\HasCache;

class App implements CommunicateWithApi
{
    use HasAbilities, HasCache;

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

    public function http()
    {
        return $this->http = $this->http ?: new Factory;
    }

    public function httpUsing($factory)
    {
        $this->http = $factory;

        return $this;
    }

    public function newRequest(): PendingRequest
    {
        return $this->http()->baseUrl($this->endpoint());
    }
}
