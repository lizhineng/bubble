<?php

namespace Zhineng\Bubble\Tests\Work;

use PHPUnit\Framework\TestCase;
use Zhineng\Bubble\Work\Messages\MarkdownMessage;
use Zhineng\Bubble\Work\Messages\TextMessage;

class MessageTest extends TestCase
{
    public function test_text_message_should_have_a_valid_payload()
    {
        $message = new TextMessage('foo');
        $this->assertSame('text', $message->type());
        $this->assertSame(['content' => 'foo'], $message->payload());
    }

    public function test_markdown_message_should_have_a_valid_payload()
    {
        $message = new MarkdownMessage('# Title');
        $this->assertSame('markdown', $message->type());
        $this->assertSame(['content' => '# Title'], $message->payload());
    }
}
