<?php

namespace Zhineng\Bubble\Http;

use GuzzleHttp\Client;

class PendingRequest
{
    protected string $baseUrl = '';

    public function baseUrl(string $url)
    {
        $this->baseUrl = $url;

        return $this;
    }

    public function post(string $url, $data = [])
    {
        $url = $this->baseUrl.$url;

        return $this->client()->request('POST', $url, [
            'json' => $data,
        ]);
    }

    public function client(): Client
    {
        return new Client;
    }
}