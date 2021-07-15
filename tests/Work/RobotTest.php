<?php

namespace Zhineng\Bubble\Tests\Work;

use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Work\Messages\TextMessage;
use Zhineng\Bubble\Work\Robot;

class RobotTest extends TestCase
{
    public function test_sends_a_raw_message()
    {
        $robot = $this->robot('__key');

        $payload = ['msgtype' => 'text', 'text' => ['content' => 'foo']];

        $robot->expects($this->once())
            ->method('request')
            ->with('POST', '/cgi-bin/webhook/send', [
                'query' => ['key' => '__key'],
                'json' => $payload,
            ]);

        $robot->sendRaw($payload);
    }

    public function test_sends_a_message_from_instance()
    {
        $robot = $this->robot('__key');

        $robot->expects($this->once())
            ->method('request')
            ->with('POST', '/cgi-bin/webhook/send', [
                'query' => ['key' => '__key'],
                'json' => ['msgtype' => 'text', 'text' => ['content' => 'foo']],
            ]);

        $robot->send(new TextMessage('foo'));
    }

    protected function robot(string $key)
    {
        return $this->getMockBuilder(Robot::class)
            ->setConstructorArgs([$key])
            ->onlyMethods(['request'])
            ->getMock();
    }
}