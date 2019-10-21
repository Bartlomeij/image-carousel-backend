<?php

namespace App\Entity;

use SimpleXMLElement;
/**
 * Class ImagesListXmlFile
 * @package App\Entity
 */
class ImagesListXmlFile extends AbstractImagesListFile
{
    /**
     * @param string $path
     */
    public function save(string $path): void
    {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><images></images>");
        $this->arrayToXml($this->getImages(), $xml);
        $xml->asXML($path);
    }

    /**
     * @param $array
     * @param $xml
     */
    protected function arrayToXml($array, SimpleXMLElement &$xml): void
    {
            foreach ($array as $key => $value) {
            if ($value instanceof Image) {
                $subnode = $xml->addChild("image$key");
                $subnode->addChild('id', $value->getId());
                $subnode->addChild('name', $value->getName());
                $subnode->addChild('image_url', $value->getImageUrl());
                $subnode->addChild('discount_percentage', $value->getDiscountPercentage());
            }
        }
    }
}
