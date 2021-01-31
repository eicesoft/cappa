<?php
declare(strict_types=1);

namespace Cappa\Http;


/**
 * Router Manager
 * @package Cappa\Http
 */
class RouterManager
{
    private static array $routes;

    public static function add($route, $controller, $method)
    {
        self::$routes[$route] = [$controller, $method];
    }

    /**
     * @param string $path
     * @return Route|null
     */
    public static function route(string $path): ?Route
    {
        foreach (self::$routes as $pattern => $callback) {
            if (preg_match("#^/?" . $pattern . "/?$#", $path, $match)) {
                if ($match) {
                    array_shift($match);
                    return new Route($callback, $match);
                }
            }
        }

        return null;
    }
}