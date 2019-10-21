<?php

namespace App\Factory;

/**
 * Class ResponseFactory
 * @package App\Factory
 */
class ResponseFactory
{
    public const CONTENT_TYPE_APPLICATION_JSON = "application/json";
    public const CONTENT_TYPE_APPLICATION_XML = "application/xml";

    /**
     * @param string $contentType
     * @return ResponseFactoryInterface
     */
    public static function chooseContentType(?string $contentType = null): ResponseFactoryInterface
    {
        switch ($contentType) {
            case self::CONTENT_TYPE_APPLICATION_XML:
                return new XmlResponseFactory();
            default:
                return new JsonResponseFactory();
        }
    }
}
