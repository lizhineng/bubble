<?php

namespace Zhineng\Bubble\Work\Messages;

interface Message
{
    public function type(): string;

    public function payload(): array;
}
