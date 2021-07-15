<?php

namespace Zhineng\Bubble\MiniProgram;

use InvalidArgumentException;
use Zhineng\Bubble\Manager;

class MiniProgramManager extends Manager
{
    protected function getConfig($name): array
    {
        $config = $this->container['config']->get('bubble.mini_programs');

        if (! isset($config[$name])) {
            throw new InvalidArgumentException("Mini program [$name] does not exists.");
        }

        return $config[$name];
    }

    protected function makeApp(array $config): App
    {
        $app = new App($config['appid'], $config['secret']);

        if ($this->container->bound('cache')) {
            $app->cacheUsing($this->container['cache']->store($config['cache']));
        }

        return $app;
    }
}
