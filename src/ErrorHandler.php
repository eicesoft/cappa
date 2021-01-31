<?php
declare(strict_types=1);

namespace Cappa;


use Cappa\Exception\ErrorException;
use Throwable;

/**
 * Error Handler
 * @package Cappa
 */
class ErrorHandler
{
    private static array $handlers = [
    ];

    /**
     * 事件处理注册
     */
    public static function registry()
    {
        set_exception_handler([ErrorHandler::class, 'exception_handler']);
        set_error_handler([ErrorHandler::class, 'error_handler']);
    }

    public static function addHandler($handler)
    {
        self::$handlers[] = $handler;
    }
//
//    public static function display(Throwable $exception) {
//        echo $exception->getMessage();
//    }

    /**
     * @param Throwable $exception
     */
    public static function exception_handler(Throwable $exception)
    {
        foreach(self::$handlers as $handler) {
            if (is_callable($handler)) {
                try {
                    @$handler($exception);
                } catch (\Exception $ex) {
//                    pass
                }
            } else if (is_array($handler)) {
                @call_user_func($handler, $exception);
            }
        }
    }

    /**
     * 转化为错误异常.
     * @param int $errno
     * @param string $err_str
     * @param string $err_file
     * @param int $err_line
     * @param array $err_context
     */
    public static function error_handler(int $errno, string $err_str, string $err_file, int $err_line, array $err_context=[])
    {
        self::exception_handler(new ErrorException(var_export([
            'message' => $err_str,
            'file' => $err_file,
            'line' => $err_line,
            'context' => $err_context
        ], true), $errno));
    }
}