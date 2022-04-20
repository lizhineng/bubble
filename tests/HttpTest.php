<?php

namespace Zhineng\Bubble\Tests;

use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Http\Factory;

abstract class HttpTest extends TestCase
{
    protected Factory $http;

    protected function setUp(): void
    {
        parent::setUp();

        $this->http = new Factory;
    }
}