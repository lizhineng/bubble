<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Ability;

class SubscribeMessageAbility extends Ability
{
    /**
     * @param  array  $data
     * @return \Zhineng\Bubble\Http\Response
     * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.send.html
     */
    public function send(array $data)
    {
        return $this->app->newRequest()->post('/cgi-bin/message/subscribe/send?access_token='.$this->app->token(), $data);
    }

    public function newMessageFromTemplate(string $templateId)
    {
        return new SubscribeMessageSender($this, $templateId);
    }
}
