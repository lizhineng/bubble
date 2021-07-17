<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use GuzzleHttp\Client;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\MiniProgram\App;
use Zhineng\Bubble\MiniProgram\Auth;
use Zhineng\Bubble\MiniProgram\Encrypter;
use Zhineng\Bubble\MiniProgram\SubscribeMessage;
use Zhineng\Bubble\Tests\InteractsWithResponse;

class AppTest extends TestCase
{
    use InteractsWithResponse;

    /**
     * @dataProvider provides_mini_program_abilities
     */
    public function test_has_ability(string $slug, string $class)
    {
        $this->assertInstanceOf($class, $this->makeApp()->{$slug});
    }

    public function test_retrieves_ability_through_method()
    {
        $this->assertInstanceOf(Auth::class, $this->makeApp()->auth());
    }

    public function test_retrieves_unsupported_ability()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Mini program does not support ability [not-exists].');
        $this->makeApp()->ability('not-exists');
    }

    public function test_retrieves_encrypter()
    {
        $encrypter = $this->makeApp()->encrypter('HyVFkGl5F5OQWJZZaNzBBg==');
        $this->assertInstanceOf(Encrypter::class, $encrypter);
    }

    public function test_retrieve_access_token()
    {
        $client = $this->getMockBuilder(Client::class)->onlyMethods(['request'])->getMock();
        $client->method('request')
            ->with('GET', '/cgi-bin/token', $this->anything())
            ->willReturn($this->fakePsr7Response(['access_token' => '__access_token', 'expires_in' => 7200]));

        $app = $this->makeApp()->setClient($client)->cacheUsing($cache = new Repository(new ArrayStore));

        $this->assertFalse($cache->has($cacheKey = $app->cacheKeyFor('token')));
        $token = $app->token();
        $this->assertTrue($cache->has($cacheKey));
        $this->assertSame('__access_token', $token);
    }

    public function test_retrieves_access_token_without_cache()
    {
        $client = $this->getMockBuilder(Client::class)->onlyMethods(['request'])->getMock();
        $client->method('request')
            ->with('GET', '/cgi-bin/token', $this->anything())
            ->willReturn($this->fakePsr7Response(['access_token' => '__access_token', 'expires_in' => 7200]));

        $app = $this->makeApp()->setClient($client);

        $this->assertSame('__access_token', $app->token());
    }

    public function test_generates_cache_key()
    {
        $this->assertEquals('bubble.mini_programs.appid.token', $this->makeApp('appid')->cacheKeyFor('token'));
    }

    public function provides_mini_program_abilities(): array
    {
        return [
            'auth' => ['auth', Auth::class],
            'subscription message' => ['subscribe_message', SubscribeMessage::class],
        ];
    }

    protected function makeApp(string $appId = '__key', string $appSecret = '__secret'): App
    {
        return new App($appId, $appSecret);
    }
}
