<?php

namespace Zhineng\Bubble;

use Zhineng\Bubble\Http\Factory;
use Zhineng\Bubble\Http\PendingRequest;

trait ManagesHttp
{
    protected ?Factory $http = null;

    public function http()
    {
        return $this->http = $this->http ?: new Factory;
    }

    public function httpUsing($factory)
    {
        $this->http = $factory;

        return $this;
    }

    public function newRequest(): PendingRequest
    {
        return $this->http()->baseUrl($this->apiEndpoint());
    }
}