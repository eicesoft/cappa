<?php
declare(strict_types=1);


use Cappa\Cappa;

if (!function_exists('app')) {
    /**
     * @return Cappa
     */
    function app(): Cappa
    {
        return Cappa::Instance();
    }
}