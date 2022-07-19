<?php

namespace Zhineng\Bubble\Concerns;

use BadMethodCallException;
use InvalidArgumentException;
use Zhineng\Bubble\Ability;

trait HasAbilities
{
    protected array $resolved = [];

    public function ability(string $ability)
    {
        if (isset($this->resolved[$ability])) {
            return $this->resolved[$ability];
        }

        return $this->resolved[$ability] = $this->resolve($ability);
    }

    public function hasAbility(string $ability): bool
    {
        return isset($this->abilities[$ability]);
    }

    protected function resolve(string $ability): Ability
    {
        if (! isset($this->abilities[$ability])) {
            throw new InvalidArgumentException("Unsupported ability [{$ability}].");
        }

        return new $this->abilities[$ability]($this);
    }

    public function __get(string $name)
    {
        if ($this->hasAbility($name)) {
            return $this->ability($name);
        }

        return null;
    }

    public function __call(string $method, array $arguments)
    {
        if ($this->hasAbility($method)) {
            return $this->$method;
        }

        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()', static::class, $method
        ));
    }
}
