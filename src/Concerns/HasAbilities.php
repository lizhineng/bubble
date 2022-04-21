<?php

namespace Zhineng\Bubble\Concerns;

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
}
