<?php

namespace Zhineng\Bubble;

use Zhineng\Bubble\Contracts\ApiClient;

abstract class Ability
{
    public function __construct(
        protected ApiClient $app
    ) {
        //
    }

    public static function make(ApiClient $app)
    {
        return new static($app);
    }
}