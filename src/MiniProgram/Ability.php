<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Contracts\CommunicateWithApi;

abstract class Ability
{
    public function __construct(
        protected CommunicateWithApi $app
    ) {
        //
    }

    public static function make(App $app)
    {
        return new static($app);
    }
}