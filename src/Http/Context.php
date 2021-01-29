<?php

namespace Cappa\Http;


use Cappa\Di\Annotation\Component;
use Cappa\Http\Response\Response;

#[Component]
class Context
{
    private Response $response;

    /**
     * @return mixed
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}