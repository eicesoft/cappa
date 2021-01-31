<?php
namespace Sms\Http\Controller;

use Cappa\Di\Annotation\Controller;
use Cappa\Di\Annotation\Route;
use Cappa\Http\BaseController;
use Cappa\Http\Request\Request;

#[Controller(path: "/sms", desc: "短信相关接口")]
class IndexController extends BaseController
{
    #[Route(path: "/test")]
    public function index(Request $request)
    {
//        dump($this->context);
//        $this->getResponse()->header('SSSS', 'sdsdg');
        $this->getResponse()->header('Server', 'jjjjjj');
        return [
            'code' => 400,
            'message' => 'text: ' . $request->input('name')
        ];
    }

    #[Route(path: "/demo/(\w+)")]
    public function demo(Request $request)
    {
        return '225';
    }
}