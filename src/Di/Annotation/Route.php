<?php
declare(strict_types=1);

namespace Cappa\Di\Annotation;


use Attribute;
use Cappa\Http\HttpMethod;
use JetBrains\PhpStorm\Pure;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final class Route extends Document
{
    private string $path;

    private int $method;

    /**
     * Controller constructor.
     * @param string $path
     * @param int $method
     * @param string $desc
     */
    #[Pure] public function __construct(string $path = '/', int $method = HttpMethod::GET, string $desc = '')
    {
        $this->path = $path;
        $this->method = $method;

        parent::__construct($desc);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getMethod(): int
    {
        return $this->method;
    }
}