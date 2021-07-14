<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Zhineng\Bubble\MiniProgram\Auth;

class AuthTest extends UnitTest
{
    public function test_retrieves_session_key()
    {
        $app = $this->makeMiniProgram();

        $app->expects($this->once())
            ->method('request')
            ->with('GET', '/sns/jscode2session', [
                'query' => [
                    'appid' => 'foo',
                    'secret' => 'bar',
                    'js_code' => 'code',
                    'grant_type' => 'authorization_code',
                ],
            ]);

        $this->auth($app)->session('code');
    }

    public function test_retrieves_access_token()
    {
        $app = $this->makeMiniProgram();

        $app->expects($this->once())
            ->method('request')
            ->with('GET', '/cgi-bin/token', [
                'query' => [
                    'grant_type' => 'client_credential',
                    'appid' => 'foo',
                    'secret' => 'bar',
                ],
            ]);

        $this->auth($app)->token();
    }

    protected function auth($app): Auth
    {
        return new Auth($app);
    }
}
