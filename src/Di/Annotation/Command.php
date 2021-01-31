<?php


namespace Cappa\Di\Annotation;


use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Command
{
    private string $name;
    private string $desc;

    /**
     * Command constructor.
     * @param string $name
     * @param string $desc
     */
    public function __construct(string $name='', string $desc='')
    {
        $this->name = $name;
        $this->desc = $desc;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}