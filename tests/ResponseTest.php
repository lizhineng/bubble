<?php

namespace Zhineng\Bubble\Tests;

use GuzzleHttp\Psr7\Response as Psr7Response;
use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Support\Response;

class ResponseTest extends TestCase
{
    use InteractsWithResponse;

    public function test_decodes_json_response()
    {
        $response = $this->fakeResponse($payload = ['foo' => ['bar' => 'baz']]);
        $this->assertSame(200, $response->status());
        $this->assertTrue($response->ok());
        $this->assertTrue($response->successful());
        $this->assertSame($payload, $response->json());
        $this->assertSame($payload['foo'], $response->json('foo'));
        $this->assertSame('baz', $response->json('foo.bar'));
        $this->assertNull($response->json('foo.bar.baz'));
        $this->assertSame('default', $response->json('foo.bar.baz', 'default'));
    }
}
