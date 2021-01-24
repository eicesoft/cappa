<?php
declare(strict_types=1);

namespace Cappa;

use Cappa\Di\Annotation\Component;

#[Component(lazy: false)]
class Config
{
    private array $configs = [];

    public function __construct()
    {

    }

    public function get($key, $default=null)
    {
        $keys = explode('.', $key);
        $module = array_shift($keys);
        var_dump($module);
        var_dump($keys);
    }
}