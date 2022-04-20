<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Zhineng\Bubble\MiniProgram\MiniProgramState;
use Zhineng\Bubble\Miniprogram\SubscribeMessageAbility;

class SubscribeMessageAbilityTest extends MiniProgramTest
{
    public function test_sends_a_message()
    {
        SubscribeMessageAbility::make($app = $this->fakeApp())->send(['foo' => 'bar']);

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token='.$app->token()
                && $request['foo'] === 'bar';
        });
    }

    public function test_builder_sends_a_message()
    {
        SubscribeMessageAbility::make($app = $this->fakeApp())
            ->newMessageFromTemplate('foo')
            ->withPayload(['bar' => 'baz'])
            ->sendTo('openid');

        $app->http()->assertSent(function ($request) use ($app) {
            return $request->method() === 'POST'
                && $request->url() === 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token='.$app->token()
                && $request['touser'] === 'openid'
                && $request['template_id'] === 'foo'
                && $request['data'] === ['bar' => ['value' => 'baz']];
        });
    }

    public function test_builder_page_redirection()
    {
        SubscribeMessageAbility::make($app = $this->fakeApp())
            ->newMessageFromTemplate('foo')
            ->redirectTo('index?foo=bar')
            ->sendTo('openid');

        $app->http()->assertSent(function ($request) use ($app) {
            return $request['page'] === 'index?foo=bar';
        });
    }

    public function test_builder_language_chooser()
    {
        SubscribeMessageAbility::make($app = $this->fakeApp())
            ->newMessageFromTemplate('foo')
            ->lang('en_US')
            ->sendTo('openid');

        $app->http()->assertSent(fn ($request) => $request['lang'] === 'en_US');
    }

    public function test_builder_app_version_control()
    {
        SubscribeMessageAbility::make($app = $this->fakeApp())
            ->newMessageFromTemplate('foo')
            ->version(MiniProgramState::Developer)
            ->sendTo('openid');

        $app->http()->assertSent(fn ($request) => $request['miniprogram_state'] === MiniProgramState::Developer->value);
    }
}
