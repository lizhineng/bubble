<?php

return [

    'mini_programs' => [

        'default' => [
            'appid' => env('WECHAT_MINI_PROGRAM_ID'),
            'secret' => env('WECHAT_MINI_PROGRAM_SECRET'),
            'cache' => 'file',
        ],

    ],

];