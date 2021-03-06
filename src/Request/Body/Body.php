<?php
namespace Kartenmacherei\RestFramework\Request\Body;

use Kartenmacherei\RestFramework\Response\Content\ContentType;

abstract class Body
{
    /**
     * @param string $inputStream
     * @return Body|JsonBody
     * @throws UnsupportedRequestBodyException
     */
    public static function fromSuperGlobals(string $inputStream = 'php://input'): Body
    {
        $content = file_get_contents($inputStream);

        if (empty($content) && empty($_POST)) {
            return new EmptyBody();
        }

        if (!isset($_SERVER['CONTENT_TYPE']) || empty($_SERVER['CONTENT_TYPE'])) {
            return new RawBody($content);
        }

        $contentType = explode(';', $_SERVER['CONTENT_TYPE']);

        switch (reset($contentType)) {
            case ContentType::JSON:
            case ContentType::JSON_UTF8:
                return new JsonBody($content);
            case ContentType::MULTIPART_FORMDATA:
                return new FormDataBody($_POST);
            case ContentType::PDF:
                return new PdfBody($content);
        }
        throw new UnsupportedRequestBodyException();
    }

    /**
     * @return bool
     */
    abstract public function isJson(): bool;
}
