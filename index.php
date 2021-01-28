<?php

use Cappa\Http\Response\Response;

include 'vendor/autoload.php';

$config = [
    'ROOT_PATH' => __DIR__,
    'APP_PATH' => __DIR__ . '/app'
];

try {
    app()->config($config)
        ->scan_path($config['APP_PATH'])
        ->add_error_handler(function ($exception) {
            dump($exception);
        })
        ->execute();
} catch (Exception $ex) {
    (new Response('<pre>' . $ex::class . '' . $ex->getMessage() . PHP_EOL . $ex->getTraceAsString() . '</pre>', 500))->send();
}

//    var_dump(env('APP_NAME', 'test'));
//    var_dump(env('TEST', 'test'));
//
//
//$config = new Config();
//dump($config->get('test.name'));
//dump($config->get('test'));
//dump($config->get('test2', 666));
//dump($config->get('test.sdgsdg', 23251));
//dump($config->get('test.app.name'));
//dump($config);
//$c = 10 / 0;

//    trigger_error('这个错误NB');
//    throw new Exception('这个错误够呛了');
//$classloader = new Composer\Autoload\ClassLoader();
//$classloader->setPsr4('Sms\\', __DIR__ . '/app/Modules/Sms');
//// activate the autoloader
//$classloader->register();
//$classloader->setUseIncludePath(true);
//
//$s = new \Sms\Http\Controller\IndexController();
//var_dump($s);
///** @var Test $obj */
//$obj = Container::get()->get(Test::class);
//var_dump($obj->test());