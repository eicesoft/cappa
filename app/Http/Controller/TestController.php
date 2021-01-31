<?php


namespace App\Http\Controller;


use Cappa\Di\Annotation\Controller;
use Cappa\Di\Annotation\Response;
use Cappa\Di\Annotation\Route;

#[Controller(path: "/test" )]
class TestController
{
    #[Route(path: "/index")]
    #[Response]
    public function index()
    {

    }
}