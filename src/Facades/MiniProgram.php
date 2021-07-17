<?php

namespace Zhineng\Bubble\Facades;

use Illuminate\Support\Facades\Facade;
use Zhineng\Bubble\MiniProgram\MiniProgramManager;

/**
 * @method static \Zhineng\Bubble\MiniProgram\App using(string $name)
 * @method static \Zhineng\Bubble\MiniProgram\Auth auth()
 * @method static \Zhineng\Bubble\MiniProgram\Encrypter encrypter(string $sessionKey)
 */
class MiniProgram extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MiniProgramManager::class;
    }
}
