<?php

namespace Zhineng\Bubble\Tests;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Zhineng\Bubble\Support\Response;

trait InteractsWithResponse
{
    protected function fakeResponse(array|string $body, $status = 200): Response
    {
        return new Response($this->fakePsr7Response($body, $status));
    }

    protected function fakePsr7Response(array|string $body, $status = 200): Psr7Response
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }

        return new Psr7Response($status, body: $body);
    }
}