<?php

namespace Zhineng\Bubble\Tests\Work;

use Zhineng\Bubble\Tests\HttpTest;
use Zhineng\Bubble\Work\Messages\TextMessage;
use Zhineng\Bubble\Work\Robot;

class RobotTest extends HttpTest
{
    public function test_sends_a_raw_message()
    {
        $robot = $this->robot('__key');

        $robot->sendRaw(['foo' => 'bar']);

        $this->http->assertSent(function ($request) {
            return $request->method() === 'POST'
                && $request->url() === 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=__key'
                && $request['foo'] === 'bar';
        });
    }

    public function test_sends_a_message_from_instance()
    {
        $this->robot('__key')->send(new TextMessage('foo'));

        $this->http->assertSent(function ($request) {
            return $request->method() === 'POST'
                && $request->url() === 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=__key'
                && $request['msgtype'] === 'text'
                && $request['text']['content'] === 'foo';
        });
    }

    protected function robot(string $key)
    {
        return (new Robot($key))
            ->httpUsing($this->http->fake());
    }
}