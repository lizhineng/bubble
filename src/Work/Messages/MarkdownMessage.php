<?php

namespace Zhineng\Bubble\Work\Messages;

class MarkdownMessage extends TextMessage
{
    public function type(): string
    {
        return 'markdown';
    }
}