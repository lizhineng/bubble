<?php

namespace Zhineng\Bubble\OfficialAccount;

use Zhineng\Bubble\Contracts\ApiClient;
use Zhineng\Bubble\ManagesHttp;
use Zhineng\Bubble\Concerns\HasAbilities;

class App implements ApiClient
{
    use ManagesHttp, HasAbilities;

    protected array $abilities = [
        'token' => AccessTokenAbility::class,
    ];

    public function __construct(
        protected string $appId,
        protected string $appSecret
    ) {
        //
    }

    public function appId(): string
    {
        return $this->appId;
    }

    public function appSecret(): string
    {
        return $this->appSecret;
    }

    public function apiEndpoint(): string
    {
        return 'https://api.weixin.qq.com';
    }

    public function token()
    {
        $response = $this->ability('token')->token();

        return $response->json('access_token');
    }
}