<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\MiniProgram\App;

abstract class UnitTest extends TestCase
{
    public function makeMiniProgram(string $appId = 'foo', string $appSecret = 'bar'): MockObject
    {
        $app = $this->getMockBuilder(App::class)
            ->setConstructorArgs([$appId, $appSecret])
            ->onlyMethods(['request', 'token'])
            ->getMock();

        $app->method('token')->willReturn('__token');

        return $app;
    }
}