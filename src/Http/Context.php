<?php

namespace Cappa\Http;


use Cappa\Di\Annotation\Component;
use Cappa\Http\Response\Response;
use Illuminate\Container\Container;

#[Component]
class Context
{
    /**
     * @return mixed
     */
    public function getResponse(): Response
    {
        return Container::getInstance()->get(Response::class);
    }
}