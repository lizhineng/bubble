<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase;

abstract class FeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpContainer();
        $this->setUpConfigRepository();
    }

    protected function container(string $key = null)
    {
        $container = Container::getInstance();

        return is_null($key) ? $container : $container->make($key);
    }

    private function setUpContainer()
    {
        $container = Container::setInstance(new Container);

        Facade::setFacadeApplication($container);
    }

    private function setUpConfigRepository()
    {
        $container = Container::getInstance();

        $container['config'] = new Repository;
    }
}