<?php


namespace Cappa\Http;


use Cappa\Http\Response\Response;
use Exception;
use Throwable;

/**
 * Class Route
 * @package Cappa\Http
 */
class Route
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var array
     */
    protected array $params;

    /**
     * Route constructor.
     * @param callable $callable
     * @param array $params
     */
    public function __construct(callable $callable, array $params = [])
    {
        $this->callable = $callable;
        $this->params = $params;
    }

    private function warpException(Throwable $ex): array
    {
        return [
            'code' => $ex->getCode(),
            'message' => $ex->getMessage(),
            'data' => $ex->getTrace(),
        ];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function handle($request)
    {
        try {
            $result = call_user_func_array($this->callable, [$request]);
        } catch (Exception $exception) {
            return Response::factory(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    /**
     * @return BaseController|Proxy
     */
    public function controller()
    {
        return $this->callable[0];
    }
}