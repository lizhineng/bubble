<?php

namespace Zhineng\Bubble\Tests;

use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Http\Factory;

class HttpTest extends TestCase
{
    protected Factory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new Factory;
    }

    public function test_fake_response()
    {
        $this->factory->fake();

        $response = $this->factory->get('https://foo.test');

        $this->assertTrue($response->ok());
    }
}