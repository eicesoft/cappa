<?php

use Cappa\Cappa;
use Cappa\Di\Container;
use Cappa\Test;

include 'vendor/autoload.php';

$cappa = Cappa::Instance();
$cappa->add_scan_paths(__DIR__ . '/app');
$cappa->execute();
///** @var Test $obj */
//$obj = Container::get()->get(Test::class);
//var_dump($obj->test());