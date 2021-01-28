<?php
declare(strict_types=1);

namespace Cappa\Http;


use Cappa\Http\Request\Request;
use Cappa\Http\Response\Response;

interface Kernel
{
    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap();

    /**
     * Handle an incoming HTTP request.
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response;

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response);
}