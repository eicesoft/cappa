<?php
return [
    //加载的子模块
    'modules' => [
        "Sms"
    ],

    'providers' => [
        \App\Providers\MiddlewareServiceProvider::class,
        \App\Providers\ModuleServiceProvider::class
    ]
];