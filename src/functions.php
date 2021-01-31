<?php
declare(strict_types=1);


use Cappa\Cappa;
use Cappa\Config;
use Cappa\Di\Container;

if (!function_exists('app')) {
    /**
     * @return Cappa
     */
    function app(): Cappa
    {
        return Cappa::Instance();
    }
}

if (!function_exists('config')) {
    /**
     * @return Config
     */
    function config()
    {
        return Container::get()->get(Config::class);
    }
}