<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use InvalidArgumentException;
use Zhineng\Bubble\MiniProgram\AuthAbility;
use Zhineng\Bubble\MiniProgram\Encrypter;
use Zhineng\Bubble\MiniProgram\SubscribeMessageAbility;

class AppTest extends MiniProgramTest
{
    /**
     * @dataProvider provides_mini_program_abilities
     */
    public function test_ability_resolution(string $slug, string $class)
    {
        $this->assertInstanceOf($class, $this->fakeApp()->{$slug});
    }

    public function test_unsupported_ability_resolution()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Mini program does not support ability [not-exists].');
        $this->fakeApp()->ability('not-exists');
    }

    public function test_encrypter_resolution()
    {
        $encrypter = $this->fakeApp()->encrypter('HyVFkGl5F5OQWJZZaNzBBg==');
        $this->assertInstanceOf(Encrypter::class, $encrypter);
    }

    public function test_retrieves_access_token()
    {
        $token = $this->fakeApp()->token();
        $this->assertSame('__fake_token', $token);
    }

    public function test_retrieves_access_token_with_cache()
    {
        $app = $this->fakeApp()->cacheUsing($cache = new Repository(new ArrayStore));

        $this->assertFalse($cache->has($cacheKey = $app->cacheKeyFor('token')));
        $token = $app->token();
        $this->assertTrue($cache->has($cacheKey));
        $this->assertSame('__fake_token', $token);
    }

    public function test_cache_key_generation()
    {
        $this->assertEquals('bubble.mini_programs.appid.token', $this->fakeApp('appid')->cacheKeyFor('token'));
    }

    public function provides_mini_program_abilities(): array
    {
        return [
            'auth' => ['auth', AuthAbility::class],
            'subscription message' => ['subscribe_message', SubscribeMessageAbility::class],
        ];
    }
}
