<?php


namespace Cappa\Http\Response;

use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class Response extends BaseResponse
{
    public function header($key, $value)
    {
        $this->headers->add([$key => $value]);
    }

    public function setBody($content)
    {
        dump($this->headers);
        if (is_object($content)) {
            $text = serialize($content);
        } elseif (is_array($content)) {
            $text = json_encode($content);
        } elseif (is_scalar($content)) {
            $text = $content;
        } else {
            $text = var_export($content, true);
        }

        $this->setContent($text);
    }

    /**
     * @param int $code
     * @return Response
     */
    public static function factory(int $code): Response
    {
        if (self::$statusTexts[$code]) {
            return new Response(self::$statusTexts[$code], $code);
        } else {
            return new Response("The unknown Code", $code);
        }
    }

    public static function base(): Response
    {
        return new Response();
    }
}