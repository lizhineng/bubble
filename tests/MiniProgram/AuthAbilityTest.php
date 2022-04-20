<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Zhineng\Bubble\MiniProgram\AuthAbility;

class AuthAbilityTest extends MiniProgramTest
{
    public function test_retrieves_session_key_by_js_code()
    {
        AuthAbility::make($app = $this->fakeApp())->code2Session('foo');

        $app->http()->assertSent(function ($request) use ($app) {
            $query = http_build_query([
                'appid' => $app->appId(),
                'secret' => $app->appSecret(),
                'js_code' => 'foo',
                'grant_type' => 'authorization_code',
            ]);

            return $request->method() === 'GET'
                && $request->url() === 'https://api.weixin.qq.com/sns/jscode2session?'.$query;
        });
    }

    public function test_retrieves_access_token()
    {
        AuthAbility::make($app = $this->fakeApp())->getAccessToken();

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

    public function test_checks_encrypted_data()
    {
        AuthAbility::make($app = $this->fakeApp())->checkEncryptedData('foo');

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.weixin.qq.com/wxa/business/checkencryptedmsg?access_token='.$app->token()
                && $request['encrypted_msg_hash'] === 'foo';
        });
    }

    public function test_gets_paid_union_id_by_transaction()
    {
        AuthAbility::make($app = $this->fakeApp())->getPaidUnionIdByTransaction('foo', 'bar');

        $query = http_build_query([
            'access_token' => $app->token(),
            'openid' => 'foo',
            'transaction_id' => 'bar',
        ]);

        $app->http()->assertSent(function ($request) use ($query) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.weixin.qq.com/wxa/getpaidunionid?'.$query;
        });
    }

    public function test_gets_paid_union_id_by_merchant()
    {
        AuthAbility::make($app = $this->fakeApp())->getPaidUnionIdByMerchant('foo', 'bar', 'baz');

        $query = http_build_query([
            'access_token' => $app->token(),
            'openid' => 'foo',
            'mch_id' => 'bar',
            'out_trade_no' => 'baz',
        ]);

        $app->http()->assertSent(function ($request) use ($query) {
            return $request->method() === 'GET'
                && $request->url() === 'https://api.weixin.qq.com/wxa/getpaidunionid?'.$query;
        });
    }

    public function test_gets_open_pid_in_plugin_mode()
    {
        AuthAbility::make($app = $this->fakeApp())->getPluginOpenPId('foo');

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.weixin.qq.com/wxa/getpluginopenpid?access_token='.$app->token()
                && $request['code'] === 'foo';
        });
    }
}
