<?php
declare(strict_types=1);

namespace Cappa\Di\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_ALL)]
class Document
{
    protected string $desc;

    /**
     * Document constructor.
     * @param string $desc
     */
    public function __construct(string $desc = '')
    {
        $this->desc = $desc;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }
}