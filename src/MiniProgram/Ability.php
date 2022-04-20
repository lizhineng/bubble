<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Contracts\ApiClient;

abstract class Ability
{
    public function __construct(
        protected ApiClient $app
    ) {
        //
    }

    public static function make(App $app)
    {
        return new static($app);
    }
}