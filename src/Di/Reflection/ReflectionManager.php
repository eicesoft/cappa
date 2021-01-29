<?php
declare(strict_types=1);

namespace Cappa\Di\Reflection;


use Cappa\Di\Proxy;
use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Reflection Manager
 * @package Cappa\Di\Reflection
 */
class ReflectionManager
{
    /**
     * @var string[]
     */
    private static array $interface_maps = [];


    /**
     * @var ReflectionClass[]
     */
    private static array $reflections = [];

    /**
     * @param $class_name
     * @return ReflectionClass
     */
    public static function get($class_name)
    {
        if (!isset(self::$reflections[$class_name])) {
            try {
                $ref = new ReflectionClass($class_name);
                if ($ref) {
                    self::$reflections[$class_name] = $ref;
                }

                return $ref;
            } catch (Exception $ex) {
                //pass;
//                dump($ex);
            }
        } else {
            return self::$reflections[$class_name];
        }
    }

    /**
     * @param string $class_name
     * @return mixed
     */
    public static function create(string $class_name)
    {
        try {
            $reflection = self::get($class_name);
//            dump($class_name);
            $interfaces = $reflection->getInterfaceNames();
            if ($interfaces) {
                foreach ($interfaces as $interface) {
                    if (!isset(self::$interface_maps[$interface])) {
                        self::$interface_maps[$interface] = $class_name;
                    }
                }
            }

            return new Proxy($class_name);
        } catch (Exception $e) {
            dump($e);
            return null;
        }
    }
}