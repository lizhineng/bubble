<?php

namespace Zhineng\Bubble\Tests\OfficialAccount;

use Zhineng\Bubble\OfficialAccount\AccessTokenAbility;

class AccessTokenAbilityTest extends OfficialAccountTest
{
    public function test_retrieves_access_token()
    {
        AccessTokenAbility::make($app = $this->fakeApp())->token();

        $app->http()->assertSent(function ($request) use ($app) {
            $query = http_build_query([
                'grant_type' => 'client_credential',
                'appid' => $app->appId(),
                'secret' => $app->appSecret(),
            ]);

            return $request->method() === 'GET'
                && $request->url() === 'https://api.weixin.qq.com/cgi-bin/token?'.$query;
        });
    }
}