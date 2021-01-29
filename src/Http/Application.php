<?php
declare(strict_types=1);

namespace Cappa\Http;


use Cappa\Config;
use Cappa\Di\Annotation\Autowiring;
use Cappa\Di\Annotation\Component;
use Cappa\Di\Container;
use Cappa\Http\Request\Request;
use Cappa\Http\Response\Response;
use Composer\Autoload\ClassLoader;

#[Component]
class Application implements Kernel
{
    /**
     * 加载子模块
     */
    public function load_submodule()
    {
        $config = config()->get('boot');
        $modules = $config['modules'] ?? [];
        $classloader = new ClassLoader();
        foreach ($modules as $prefix => $module) {
            $classloader->setPsr4($prefix, ROOT_PATH . '/app/Modules/' . $module);
        }

        $classloader->register();
        $classloader->setUseIncludePath(true);

        foreach ($modules as $prefix => $module) {
            new \Cappa\Loader\ClassLoader(ROOT_PATH . '/app/Modules/' . $module);
        }
    }

    /**
     *
     */
    public function bootstrap()
    {
        $this->load_submodule();

        Container::get()->warp();
//
        $providers = config()->get('boot.providers');
        foreach ($providers as $provider) {
            $provider_obj = Container::get()->make($provider);
            $provider_obj->register();
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $this->bootstrap();

        $route = RouterManager::route($request->getPathInfo());

        if ($route) {
            $response = Response::base();
            $route->controller()->getContext()->setResponse($response);
            $result = $route->handle($request);
            $response->setBody($result);
            return $response;
        } else {
            return Response::factory(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response)
    {
        $response->send();
    }
}