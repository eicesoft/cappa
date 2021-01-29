<?php
declare(strict_types=1);

namespace Cappa\Di\Annotation;


use Attribute;
use JetBrains\PhpStorm\Pure;

#[Attribute(Attribute::TARGET_CLASS)]
final class Controller extends Document
{
    private string $path;

    /**
     * Controller constructor.
     * @param string $path
     * @param string $desc
     */
    #[Pure] public function __construct(string $path = '', string $desc = '')
    {
        $this->path = $path;
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
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }
}