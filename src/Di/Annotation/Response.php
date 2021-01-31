<?php
declare(strict_types=1);

namespace Cappa\Di\Annotation;


use Attribute;
use JetBrains\PhpStorm\Pure;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
class Response extends Document
{
    const JSON_RESPONSE = 1;
    const RAW_RESPONSE = 2;
    const XML_RESPONSE = 3;
    const TEMPLATE_RESPONSE = 4;

    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_MOVE = 301;
    const HTTP_STATUS_NO_FOUND = 404;
    const HTTP_STATUS_NO_ERROR = 500;

    /**
     * @var int
     */
    private int $type;

    private string $template;

    /**
     * @var int
     */
    private int $code;

    /**
     * Response constructor.
     * @param int $code
     * @param int $type
     * @param string $template
     */
    #[Pure] public function __construct(int $code = Response::HTTP_STATUS_OK, int $type = Response::JSON_RESPONSE, string $template = '', $desc = '')
    {
        $this->code = $code;
        $this->type = $type;
        $this->template = $template;
        parent::__construct($desc);
    }
}