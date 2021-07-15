<?php

namespace Zhineng\Bubble\Work\Contracts;

interface Message
{
    public function type(): string;

    public function payload(): array;
}
