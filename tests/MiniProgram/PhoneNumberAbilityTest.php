<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Http\Factory;
use Zhineng\Bubble\MiniProgram\App;
use Zhineng\Bubble\MiniProgram\PhoneNumberAbility;

class PhoneNumberAbilityTest extends TestCase
{
    protected Factory $http;

    public function setUp(): void
    {
        parent::setUp();

        $this->http = new Factory;
    }

    public function test_retrieve_phone_number_by_code()
    {
        PhoneNumberAbility::make($app = $this->fakeApp())->get('foo');

        $this->http->assertSent(function ($request) use ($app) {
            return $request->url() === 'https://api.weixin.qq.com/wxa/business/getuserphonenumber'
                && $request['access_token'] === $app->token()
                && $request['code'] === 'foo';
        });
    }

    public function fakeApp()
    {
        return App::make('fake::app', 'fake::secret')
            ->httpUsing($this->http);
    }
}