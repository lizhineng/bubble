<?php

namespace Zhineng\Bubble\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public function __construct(
        protected ResponseInterface $response
    ) {
        //
    }
}