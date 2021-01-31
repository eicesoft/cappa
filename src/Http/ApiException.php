<?php


namespace Cappa\Http;


use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Api Exception
 * @package Cappa\Http
 */
class ApiException extends Exception
{
    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     */
    #[Pure] public function __construct(string $message, int $code=500)
    {
        parent::__construct($message, $code);
    }
}