<?php

return [

    'mini_programs' => [

        'default' => [
            'appid' => env('WECHAT_MINI_PROGRAM_ID'),
            'secret' => env('WECHAT_MINI_PROGRAM_SECRET'),
            'cache' => 'file',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | WeCom Robots
    |--------------------------------------------------------------------------
    |
    | Define WeCom robots with the alias and webhook id for your application.
    | Webhook id can be retrieved from the robot profile, below configuring
    | is the use case example, feel free to modify to suit your own needs.
    |
    */

    'robots' => [

        // 'sales_reporter' => env('WECOM_ROBOT_SALES_REPORTER'),

        // 'refund_notifier' => env('WECOM_ROBOT_REFUND_NOTIFIER'),

    ],

];