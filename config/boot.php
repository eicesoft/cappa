<?php
return [
    //加载的子模块
    'modules' => [
        'Sms\\' => 'Sms'
    ],

    'providers' => [
        \App\Providers\MiddlewareServiceProvider::class,
    ]
];