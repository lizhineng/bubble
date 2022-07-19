<?php

namespace Zhineng\Bubble\Tests;

use GuzzleHttp\Psr7\Response as PsrResponse;
use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Http\Response;

class HttpResponseTest extends TestCase
{
    public function test_body_resolution()
    {
        $this->assertSame('foo', $this->newResponse('foo')->body());
    }

    public function test_resolves_body_as_json_data()
    {
        $data = ['foo' => 'bar', 'nested' => ['foo' => 'bar']];

        $this->assertSame($data, $this->newResponse($data)->json());
        $this->assertSame($data['foo'], $this->newResponse($data)->json('foo'));
        $this->assertSame(null, $this->newResponse($data)->json('bar'));
        $this->assertSame('bar', $this->newResponse($data)->json('bar', 'bar'));
        $this->assertSame('bar', $this->newResponse($data)->json('nested.foo'));
    }

    public function test_status_code_resolution()
    {
        $this->assertSame(200, $this->newResponse()->status());
    }

    protected function newResponse($content = null, int $status = 200, array $headers = []): Response
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }

        return new Response(new PsrResponse($status, $headers, $content));
    }
}
