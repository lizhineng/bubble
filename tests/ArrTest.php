<?php

namespace Zhineng\Bubble\Tests;

use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Support\Arr;

class ArrTest extends TestCase
{
    public function test_get_return_itself_if_key_is_not_provided()
    {
        $this->assertSame(['foo' => 'bar'], Arr::get(['foo' => 'bar']));
    }

    public function test_get_key_resolution()
    {
        $this->assertSame('bar', Arr::get(['foo' => 'bar'], 'foo'));
    }

    public function test_get_key_resolution_with_dot_notation()
    {
        $this->assertSame('baz', Arr::get(['foo' => ['bar' => 'baz']], 'foo.bar'));
    }

    public function test_get_fallback_to_default_value_if_key_does_not_exists()
    {
        $this->assertSame('bar', Arr::get([], 'foo', 'bar'));
        $this->assertSame('bar', Arr::get([], 'foo.bar', 'bar'));
    }

    public function test_get_fallback_to_default_value_if_invalid_array_given()
    {
        $this->assertSame('bar', Arr::get('foo', 'foo', 'bar'));
    }
}
