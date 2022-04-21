<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Ability;

class PhoneNumberAbility extends Ability
{
    /**
     * Retrieve phone number by given code.
     *
     * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/phonenumber/phonenumber.getPhoneNumber.html
     * @param  string  $code
     * @return mixed
     */
    public function get(string $code)
    {
        return $this->app->newRequest()
            ->post('/wxa/business/getuserphonenumber?access_token='.$this->app->token(), compact('code'));
    }
}