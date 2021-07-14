<?php

namespace Zhineng\Bubble\Support;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public function __construct(
        protected ResponseInterface $response
    ) {}

    public function raw(): ResponseInterface
    {
        return $this->response;
    }
}
