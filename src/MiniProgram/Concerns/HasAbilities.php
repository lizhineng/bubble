<?php

namespace Zhineng\Bubble\MiniProgram\Concerns;

use InvalidArgumentException;
use Zhineng\Bubble\MiniProgram\Ability;
use Zhineng\Bubble\MiniProgram\AuthAbility;
use Zhineng\Bubble\MiniProgram\Encrypter;
use Zhineng\Bubble\MiniProgram\SubscribeMessageAbility;

trait HasAbilities
{
    protected array $resolved = [];

    protected array $abilities = [
        'auth' => AuthAbility::class,
        'subscribe_message' => SubscribeMessageAbility::class,
    ];

    public function encrypter(string $sessionKey): Encrypter
    {
        return (new Encrypter($sessionKey))->withApp($this);
    }

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
            throw new InvalidArgumentException("Mini program does not support ability [{$ability}].");
        }

        return new $this->abilities[$ability]($this);
    }

    public function __get(string $name)
    {
        if ($this->hasAbility($name)) {
            return $this->ability($name);
        }
    }
}
