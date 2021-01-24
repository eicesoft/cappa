<?php

use Cappa\Cappa;

include 'vendor/autoload.php';

$cappa = Cappa::Instance();
$cappa->add_scan_paths(__DIR__ . '/app');
$cappa->execute();
$config = new \Cappa\Config();
$config->get('test.name');
$config->get('test');
$classloader = new Composer\Autoload\ClassLoader();
$classloader->setPsr4('Sms\\', __DIR__ . '/app/Modules/Sms');
// activate the autoloader
$classloader->register();
$classloader->setUseIncludePath(true);

$s = new \Sms\Http\Controller\IndexController();
var_dump($s);
///** @var Test $obj */
//$obj = Container::get()->get(Test::class);
//var_dump($obj->test());