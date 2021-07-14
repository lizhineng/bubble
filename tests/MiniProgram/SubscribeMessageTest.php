<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Zhineng\Bubble\Miniprogram\SubscribeMessage;

class SubscribeMessageTest extends UnitTest
{
    public function test_sends_a_message()
    {
        $app = $this->makeMiniProgram();

        $data = [
            'touser' => '__open_id',
            'template_id' => '__template_id',
            'data' => [
                'number01' => [
                    'value' => '__value',
                ],
            ],
        ];

        $app->expects($this->once())
            ->method('request')
            ->with('POST', '/cgi-bin/message/subscribe/send', [
                'query' => ['access_token' => '__token'],
                'json' => $data,
            ]);

        $this->service($app)->send($data);
    }

    protected function service($app): SubscribeMessage
    {
        return new SubscribeMessage($app);
    }
}
