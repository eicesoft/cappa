<?php
namespace App\Http\Controller;


use App\Http\Request\ApiRequest;
use Cappa\Di\Annotation\Controller;
use Cappa\Di\Annotation\Response;
use Cappa\Di\Annotation\Route;
use Cappa\Http\ApiException;
use Cappa\Http\HttpMethod;

#[Controller]
class IndexController
{
    #[Route(path: "/index", method: HttpMethod::GET | HttpMethod::POST)]
    public function index()
    {
        if (mt_rand(1, 10) > 1) {
            throw new ApiException('故意的异常');
        }

        return [
            'code' => 200,
            'data' => ['name' => 'test'],
            'message' => '',
        ];
    }
}