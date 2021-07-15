<?php

namespace Zhineng\Bubble;

use Illuminate\Contracts\Container\Container;

abstract class Manager
{
    protected array $instances = [];

    public function __construct(
        protected Container $container
    ) {}

    public function using(string $name = null)
    {
        $name = $name ?: $this->defaultName();

        return $this->instances[$name] = $this->instances[$name] ?? $this->resolve($name);
    }

    protected function defaultName(): string
    {
        return 'default';
    }

    protected function resolve(string $name)
    {
        $config = $this->getConfig($name);

        return $this->makeApp($config);
    }

    abstract protected function getConfig($name): array;

    abstract protected function makeApp(array $config);

    public function __call(string $name, array $arguments)
    {
        return $this->using()->{$name}(...$arguments);
    }
}
