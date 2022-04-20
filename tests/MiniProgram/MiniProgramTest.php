<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Http\Factory;
use Zhineng\Bubble\MiniProgram\App;

abstract class MiniProgramTest extends TestCase
{
    protected Factory $http;

    public function setUp(): void
    {
        parent::setUp();

        $this->http = new Factory;
    }

    public function fakeApp(string $appId = '__fake_app', string $appSecret = '__fake_secret'): App
    {
        $app = m::mock(App::class, [$appId, $appSecret])->makePartial();
        $app->shouldReceive('resolveToken')->andReturn('__fake_token');

        return $app->httpUsing($this->http->fake());
    }
}