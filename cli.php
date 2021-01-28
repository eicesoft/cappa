<?php

include 'vendor/autoload.php';

$config = [
    'ROOT_PATH' => __DIR__,
    'APP_PATH' => __DIR__ . '/app'
];

try {
    app()
        ->config($config)
        ->scan_path($config['APP_PATH'])
        ->add_error_handler(function ($exception) {
            dump($exception);
        })
        ->cli();
} catch (Exception $ex) {
    dump($ex);
}
