<?php
declare(strict_types=1);

namespace Cappa\Http;


use Cappa\Config;
use Cappa\Di\Annotation\Autowiring;
use Cappa\Di\Annotation\Component;
use Cappa\Di\Container;
use Cappa\Http\Request\Request;
use Cappa\Http\Response\Response;

#[Component]
class Application implements Kernel
{
    #[Autowiring]
    private Config $config;

    /**
     *
     */
    public function bootstrap()
    {
        $providers = $this->config->get('boot.providers');
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

        return new Response(json_encode($request), 200, ['Content-type' => 'application/json']);
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