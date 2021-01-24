<?php


namespace Cappa\Di\Annotation;


use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Value
{
    private string $name;

    /**
     * Value constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}