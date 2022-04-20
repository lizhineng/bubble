<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Mockery as m;
use Zhineng\Bubble\MiniProgram\App;
use Zhineng\Bubble\Tests\HttpTest;

abstract class MiniProgramTest extends HttpTest
{
    public function fakeApp(string $appId = '__fake_app', string $appSecret = '__fake_secret'): App
    {
        $app = m::mock(App::class, [$appId, $appSecret])->makePartial();
        $app->shouldReceive('resolveToken')->andReturn('__fake_token');

        return $app->httpUsing($this->http->fake());
    }
}