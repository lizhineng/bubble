<?php

namespace Zhineng\Bubble\Tests\OfficialAccount;

use Zhineng\Bubble\OfficialAccount\MenuAbility;

class MenuAbilityTest extends OfficialAccountTest
{
    public function test_retrieves_menus()
    {
        MenuAbility::make($app = $this->fakeApp())->all();

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$app->token();
        });
    }

    public function test_creates_a_new_menu()
    {
        MenuAbility::make($app = $this->fakeApp())->create(['foo' => 'bar']);

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$app->token()
                && $request['foo'] === 'bar';
        });
    }
}