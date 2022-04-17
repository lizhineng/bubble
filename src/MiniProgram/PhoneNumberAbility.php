<?php

namespace Zhineng\Bubble\MiniProgram;

use Zhineng\Bubble\Contracts\CommunicateWithApi;

class PhoneNumberAbility
{
    public function __construct(
        protected CommunicateWithApi $app
    ) {
        //
    }

    public static function make(App $app)
    {
        return new static($app);
    }

    /**
     * Retrieve phone number by given code.
     *
     * @link https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/phonenumber/phonenumber.getPhoneNumber.html
     * @param  string  $code
     * @return mixed
     */
    public function get(string $code)
    {
        return $this->app->http()
            ->baseUrl($this->app->endpoint())
            ->post('/wxa/business/getuserphonenumber', compact('code'));
    }
}