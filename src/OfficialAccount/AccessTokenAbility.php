<?php

namespace Zhineng\Bubble\OfficialAccount;

use Zhineng\Bubble\Ability;

class AccessTokenAbility extends Ability
{
    /**
     * @param  string  $grant
     * @return \Zhineng\Bubble\Http\Response
     * @link https://developers.weixin.qq.com/doc/offiaccount/en/Basic_Information/Get_access_token.html
     * @link https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_access_token.html
     */
    public function token(string $grant = 'client_credential')
    {
        return $this->app->newRequest()->get('/cgi-bin/token', [
            'grant_type' => $grant,
            'appid' => $this->app->appId(),
            'secret' => $this->app->appSecret(),
        ]);
    }
}