<?php
declare(strict_types=1);

namespace Cappa\Http;

/**
 * HttpMethod defined
 * @package Cappa\Http
 */
final class HttpMethod
{
    const GET = 1;
    const HEAD = 1 << 1;
    const POST = 1 << 2;
    const PUT = 1 << 3;
    const DELETE = 1 << 4;
    const OPTIONS = 1 << 5;
    const PATCH = 1 << 6;
    const ALL = (1 << 7) - 1;
}