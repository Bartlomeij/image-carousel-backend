<?php

namespace App\Factory;

use App\Entity\Image;
use App\Entity\ImagesCollection;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XmlResponseFactory
 * @package App\Factory
 */
class XmlResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param ImagesCollection $imagesCollection
     * @param string $source
     * @return Response
     */
    public static function createImagesCollectionResponse(
        ImagesCollection $imagesCollection,
        string $source
    ): Response {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><root></root>');
        $xml->addChild('count', $imagesCollection->count());
        $xml->addChild('source', $source);

        $imagesSubnode = $xml->addChild("images");
        foreach ($imagesCollection->getAll() as $key => $value) {
            if ($value instanceof Image) {
                $subnode = $imagesSubnode->addChild("image$key");
                $subnode->addChild('id', $value->getId());
                $subnode->addChild('name', $value->getName());
                $subnode->addChild('image_url', $value->getImageUrl());
                $subnode->addChild('discount_percentage', $value->getDiscountPercentage());
            }
        }

        $xmlContent = $xml->asXML();
        $response = new Response($xmlContent, 200);
        $response->headers->set('Content-Type', 'application/xml');
        return $response;
    }

    /**
     * @param string $message
     * @param int|null $code
     * @return Response
     */
    public static function createErrorResponse(string $message, ?int $code = 500): Response
    {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><root></root>');
        $errorSubnode = $xml->addChild("error");
        $errorSubnode->addChild('errorMessage', $message);
        $xmlContent = $xml->asXML();

        $response = new Response($xmlContent, 500);
        $response->headers->set('Content-Type', 'application/xml');
        return $response;
    }
}
