<?php
declare(strict_types=1);

namespace Cappa\Di;


use Cappa\Command\CommandManager;
use Cappa\Di\Annotation\Command;
use Cappa\Di\Annotation\Component;
use Cappa\Di\Annotation\Controller;
use Cappa\Di\Reflection\ReflectionManager;
use Cappa\ObjectType;
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
     * @var ObjectType
     */
    private ObjectType $object_type;

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
        $this->init();
    }

    private function init()
    {
        if ($this->proxy_object === null) {
            $this->initAttr();

            try {
                if (!$this->object_type->compare(ObjectType::Other)) {
//                    dump($this->name . ":" . $this->object_type);

                    $obj = Container::get()->get($this->name);
                    if (!$obj) {
                        $obj = $this->reflection->newInstance();

                        Container::get()->put($obj);
                    }

                    $this->proxy_object = $obj;
//                    dump($obj);
                }
            } catch (ReflectionException $e) {

            }

            $this->autowire();
            $this->pre_process();
        }
    }

    private function pre_process()
    {
        if ($this->object_type instanceof ObjectType) {
            if ($this->object_type->compare(ObjectType::Command)) {
                /** @var Command $attr_obj */
                $attr_obj = $this->getAttribute(Command::class);
                CommandManager::add($this->proxy_object, $attr_obj->getName(), $attr_obj->getDesc());
            }

            if ($this->object_type->compare(ObjectType::Controller)) {  //控制器和路由注册
                $attr_obj = $this->getAttribute(Controller::class);
                $r = $this->reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
                dump($attr_obj);
                dump($r);
            }
        }
    }

    private function autowire()
    {
        $reflection_properties = $this->reflection->getProperties(ReflectionProperty::IS_PRIVATE);
//        var_dump($reflection_properties);
        foreach ($reflection_properties as $reflection_property) {
//            $reflection_property->ge();
            $reflection_property->setAccessible(true);
            $attribute = $reflection_property->getAttributes();
            $type = $reflection_property->getType();

            if ($attribute) {
                $type_name = $type->getName();
                $var_reflection = ReflectionManager::get($type_name);
//                var_dump($var_reflection);
//                dump($type_name);

                if ($var_reflection->isInterface()) {
//                    var_dump('is interface');
                    //TODO interface inject
                } else {
                    $obj = ReflectionManager::create($type_name);
//                    dump($obj->getProxyObject());
                    $reflection_property->setValue($this->proxy_object, $obj->getProxyObject()->getProxyObject());
                }
            }
        }
    }

    /**
     * @return object
     */
    public function getProxyObject(): object
    {
        return $this->proxy_object;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (!$this->proxy_object) {
            //Empty object
        }
//dd($name);
        if (!method_exists($this->proxy_object, $name)) {
            //Object method don't exists
        }

        return call_user_func_array([$this->proxy_object, $name], $arguments);
    }

    private $attribures = [];

    public function getAttribute($name)
    {
        return $this->attribures[$name] ?? null;
    }

    private function initAttr(): void
    {
        $attributes = $this->reflection->getAttributes();

        $this->object_type = ObjectType::valueOf(ObjectType::Other);

        if ($attributes) {
            foreach ($attributes as $attribute) {
                $attr_obj = $attribute->newInstance();

                $this->attribures[$attribute->getName()] = $attr_obj;

                if ($attr_obj instanceof Component) {
                    $this->object_type = ObjectType::valueOf(ObjectType::Component);
                }
//
                if ($attr_obj instanceof Command) {
                    $this->object_type = ObjectType::valueOf(ObjectType::Command);
                }

                if ($attr_obj instanceof Controller) {
                    $this->object_type = ObjectType::valueOf(ObjectType::Controller);
                }
//                dump($this->name.':'. $this->object_type->value());
            }
        }
    }
}