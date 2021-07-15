<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Zhineng\Bubble\MiniProgram\App;
use Zhineng\Bubble\MiniProgram\MiniProgramManager;

class MiniProgramManagerTest extends FeatureTest
{
    public function test_resolves_mini_program()
    {
        $manager = new MiniProgramManager($this->container());
        $this->container('config')->set('bubble', ['mini_programs' => [
            'mp1' => ['appid' => 'mp1_id', 'secret' => 'mp1_secret'],
            'mp2' => ['appid' => 'mp2_id', 'secret' => 'mp2_secret'],
        ]]);

        $miniProgram1 = $manager->using('mp1');
        $this->assertInstanceOf(App::class, $miniProgram1);
        $this->assertSame('mp1_id', $miniProgram1->appId());
        $this->assertSame($miniProgram1, $manager->using('mp1'));

        $miniProgram2 = $manager->using('mp2');
        $this->assertInstanceOf(App::class, $miniProgram2);
        $this->assertSame('mp2_id', $miniProgram2->appId());
    }

    public function test_retrieves_default_mini_program()
    {
        $manager = new MiniProgramManager($this->container());
        $this->container('config')->set('bubble', ['mini_programs' => [
            'mp1' => ['appid' => 'mp1_id', 'secret' => 'mp1_secret'],
            'default' => ['appid' => 'default_id', 'secret' => 'default_secret'],
        ]]);

        $this->assertInstanceOf(App::class, $miniProgram = $manager->using());
        $this->assertSame('default_id', $miniProgram->appId());
    }

    public function test_forwards_calls()
    {
        $manager = new MiniProgramManager($this->container());

        $this->container('config')->set('bubble', ['mini_programs' => [
            'default' => ['appid' => 'default_id', 'secret' => 'default_secret'],
        ]]);

        $this->assertSame('default_id', $manager->appId());
    }
}
