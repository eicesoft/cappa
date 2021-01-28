<?php
namespace App\Http\Controller;


use App\Http\Request\ApiRequest;
use Cappa\Di\Annotation\Controller;
use Cappa\Di\Annotation\Response;
use Cappa\Di\Annotation\Route;
use Cappa\Http\HttpMethod;

#[Controller]
class IndexController
{
    #[Route(path: "/index", method: HttpMethod::GET | HttpMethod::POST)]
    #[Response]
    public function index(ApiRequest $request)
    {

    }
}