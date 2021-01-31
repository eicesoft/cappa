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


    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default=null)
    {
        $keys = explode('.', $key);
        $module = array_shift($keys);
        $configs = $this->load_module($module);

//        var_dump($configs);
        if ($configs) {
            foreach ($keys as $k) {
                $configs = isset($configs[$k]) ? $configs[$k]: null;
            }

            return $configs ?? $default;
        } else {
            return $default;
        }
    }

    /**
     * @param string $module
     * @return array
     */
    private function load_module(string $module): array
    {
        if (!isset($this->configs[$module])) {
            $root_path = Cappa::Instance()->get('ROOT_PATH');
            $module_path = $root_path . '/config/' . $module . '.php';
            if (is_readable($module_path)) {
                $this->configs[$module] = require($module_path);
            }
        }

        return $this->configs[$module] ?? [];
    }
}