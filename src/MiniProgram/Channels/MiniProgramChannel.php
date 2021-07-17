<?php

namespace Zhineng\Bubble\MiniProgram\Channels;

use Illuminate\Notifications\Notification;
use Zhineng\Bubble\MiniProgram\MiniProgramManager;

class MiniProgramChannel
{
    public function __construct(
        protected MiniProgramManager $miniProgram
    ) {}

    public function send($notifiable, Notification $notification)
    {
        if (! $message = $notification->toWeChatMiniProgram($notifiable)) {
            return;
        }

        if (! $openid = $notifiable->routeNotificationFor('WeChatMiniProgram')) {
            return;
        }

        $this->miniProgram->using($message->miniProgram)->subscribe_message->send([
            'touser' => $openid,
            'template_id' => $message->templateId,
            'page' => $message->page,
            'data' => $message->data,
        ]);
    }
}
