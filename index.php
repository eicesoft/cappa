<?php

use Cappa\Http\Response\Response;
use Illuminate\Database\Capsule\Manager;

include __DIR__ . '/vendor/autoload.php';

$config = [
    'ROOT_PATH' => __DIR__,
    'APP_PATH' => __DIR__ . '/app'
];

try {
//    $capsule = new Manager;
//    $capsule->addConnection([]);
//    $capsule->setAsGlobal();
//    $capsule->bootEloquent();
    app()->config($config)
        ->scan_path($config['APP_PATH'])
        ->add_error_handler(function ($exception) {
            dump($exception);
        })
        ->execute();
} catch (Exception $ex) {
    (new Response('<pre>' . $ex::class . '' . $ex->getMessage() . PHP_EOL . $ex->getTraceAsString() . '</pre>', 500))->send();
}