<?php

namespace Zhineng\Bubble\Tests\OfficialAccount;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Http\Factory;
use Zhineng\Bubble\OfficialAccount\App;

abstract class OfficialAccountTest extends TestCase
{
    protected Factory $http;

    protected function setUp(): void
    {
        parent::setUp();

        $this->http = new Factory;
    }

    protected function fakeApp()
    {
        $app = m::mock(App::class, ['__fake_app', '__fake_secret'])
            ->makePartial();

        $app->shouldReceive('token')->andReturn('__fake_token');

        return $app->httpUsing($this->http->fake());
    }
}