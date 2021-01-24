<?php
namespace Cappa\Di;


/**
 * Class Container
 * @package Cappa\Di
 */
class Container
{
    /**
     * @var ContainerInterface
     */
    private static $instance;

    /**
     * @return ContainerInterface
     */
    public static function get(): ContainerInterface
    {
        if (null === self::$instance) {
            self::$instance = new ArrayContainer();
        }

        return self::$instance;
    }
}