<?php

namespace Zhineng\Bubble\OfficialAccount;

use Zhineng\Bubble\Ability;

class MenuAbility extends Ability
{
    public function all()
    {
        return $this->app->newRequest()->get('/cgi-bin/menu/get', [
            'access_token' => $this->app->token(),
        ]);
    }

    public function create(array $data)
    {
        return $this->app->newRequest()->post('/cgi-bin/menu/create?access_token='.$this->app->token(), $data);
    }
}