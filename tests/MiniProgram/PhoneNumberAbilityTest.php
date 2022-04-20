<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Zhineng\Bubble\MiniProgram\PhoneNumberAbility;

class PhoneNumberAbilityTest extends MiniProgramTest
{
    public function test_retrieves_phone_number_by_code()
    {
        PhoneNumberAbility::make($app = $this->fakeApp())->get('foo');

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token='.$app->token()
                && $request['code'] === 'foo';
        });
    }
}