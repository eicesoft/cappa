<?php


namespace Cappa\Http\Response;

use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response extends BaseResponse
{
    public function setServer($name)
    {
        $this->headers->set('Server', $name);
    }

    public function setBody($content)
    {
        if (is_object($content)) {
            $this->headers->set('Content-Type', 'application/json');
            $text = json_encode($content, true);
        } elseif (is_array($content)) {
            $this->headers->set('Content-Type', 'application/json');

            $text = json_encode($content);
        } elseif (is_string($content)) {
            $text = $content;
        } elseif (is_scalar($content)) {
            $text = $content;
        } else {
            $this->headers->set('Content-Type', 'application/json');

            $text = json_encode($content, true);
        }

        $this->setContent($text);
    }

    /**
     * @param int $code
     * @param null $message
     * @return Response
     */
    public static function factory(int $code, $message = null): Response
    {
        if ($message === null) {
            $message = self::$statusTexts[$code] ?? 'unknown code exception';
        }

        return new Response($message, $code);
    }
}