<?php


namespace Cappa\Di\Annotation;


use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Middleware
{
    public function __construct()
    {

    }
}