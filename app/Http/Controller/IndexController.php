<?php

namespace App\Http\Controller;


use Cappa\Di\Annotation\Controller;
use Cappa\Di\Annotation\Route;
use Cappa\Http\BaseController;
use Cappa\Http\HttpMethod;

#[Controller]
class IndexController extends BaseController
{
    #[Route(path: "/index", method: HttpMethod::GET | HttpMethod::POST)]
    public function index()
    {
        $this->getResponse()->headers->set('Server', 'PHP Cappa 1.0');
//
//        if (mt_rand(1, 10) > 5) {
//            throw new ApiException('故意的异常');
//        }

        return [
            'code' => 200,
            'data' => ['name' => 'test'],
            'message' => '',
        ];
    }
}