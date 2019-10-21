<?php

namespace App\Factory;

use App\Entity\ImagesCollection;
USE App\Exception\InvalidImageObjectException;
use App\Filter\ImagesCollectionFilter;

/**
 * Class ImageCollectionFactory
 * @package App\Factory
 */
class ImageCollectionFactory
{
    /**
     * @param array $objectsArray
     * @param ImagesCollectionFilter|null $imagesCollectionFilter
     * @return ImagesCollection
     * @throws InvalidImageObjectException
     */
    public static function createImageCollectionFromImageObjectsArray(
        array $objectsArray,
        ?ImagesCollectionFilter $imagesCollectionFilter = null
    ): ImagesCollection {
        $imagesCollection = new ImagesCollection();
        foreach ($objectsArray as $object) {
            $image = ImageFactory::createImageFromObject($object);
            if ($imagesCollectionFilter && !$imagesCollectionFilter->meetsRequirements($image)) {
                continue;
            }
            $imagesCollection->addImage($image);
        }
        return $imagesCollection;
    }
}
