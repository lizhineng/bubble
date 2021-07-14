<?php

namespace Zhineng\Bubble\Work\Messages;

class TextMessage implements Message
{
    public function __construct(
        protected string $content
    ) {}

    public function type(): string
    {
        return 'text';
    }

    public function payload(): array
    {
        return [
            'content' => $this->content,
        ];
    }
}
