<?php
declare(strict_types=1);

namespace Cappa\Di\Annotation;


use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Component
{
    private $name;

    private $lazy;

    private $singleton;

    public function __construct($name=null, $lazy=true, $singleton=false)
    {
        $this->name = $name;
        $this->lazy = $lazy;
        $this->singleton = $singleton;
    }

    /**
     * @return string
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isLazy(): mixed
    {
        return $this->lazy;
    }

    /**
     * @return false
     */
    public function isSingleton(): mixed
    {
        return $this->singleton;
    }
}