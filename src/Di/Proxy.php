<?php
declare(strict_types=1);

namespace Cappa\Di;


use Cappa\Di\Annotation\Component;
use Cappa\Di\Reflection\ReflectionManager;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * DynProxy
 * @package Cappa\Di
 * @author kelezyb
 * @version 0.9.0.1
 */
class Proxy
{
    /**
     * proxy object name
     * @var string
     */
    private string $name;

    private ReflectionClass $reflection;

    /**
     * @var object
     */
    private $proxy_object;

    /**
     * Proxy constructor.
     * @param $name
     * @throws Exception
     */
    public function __construct($name)
    {
        if (!class_exists($name)) {
            throw new Exception();
        }

        $this->name = $name;

        $this->reflection = ReflectionManager::get($name);
        $attributes = $this->reflection->getAttributes();

        if ($attributes) {
            foreach ($attributes as $attribute) {
                $attr_obj = $attribute->newInstance();
                if ($attr_obj instanceof Component) {
//                    var_dump($attr_obj);
                    if (!$attr_obj->isLazy()) { //非延迟
                        $this->init();
                    }
                }
            }
        }
    }

    private function init()
    {
        if (!$this->proxy_object) {
            try {
                $obj = Container::get()->get($this->name);
                if (!$obj) {
                    $obj = $this->reflection->newInstance();

                    Container::get()->put($obj);
                }

                $this->proxy_object = $obj;
            } catch (ReflectionException $e) {

            }

            $this->autowire();
        }
    }

    private function autowire()
    {
        $reflection_properties = $this->reflection->getProperties(ReflectionProperty::IS_PRIVATE);
//        var_dump($reflection_properties);
        foreach ($reflection_properties as $reflection_property) {
//            $reflection_property->ge();
            $type = $reflection_property->getType();
            if ($type && $type instanceof \ReflectionType) {
                $type_name = $type->getName();
                $var_reflection = ReflectionManager::get($type_name);
                $reflection_property->setAccessible(true);

                if ($var_reflection->isInterface()) {
                    var_dump('is interface');
                } else {
                    $reflection_property->setValue(ReflectionManager::create($type_name));
                }
            }
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        $this->init();

        if (!$this->proxy_object) {
            //Empty object
        }

        if (!method_exists($this->proxy_object, $name)) {
            //Object method don't exists
        }

        return call_user_func_array([$this->proxy_object, $name], $arguments);
    }
}