<?php

namespace App\Factory;

use App\Entity\Image;
use App\Exception\InvalidImageAssociativeArrayException;
use App\Exception\InvalidImageObjectException;

class ImageFactory
{
    /**
     * @param array $imageArray
     * @return Image
     * @throws InvalidImageAssociativeArrayException
     */
    public static function createImageFromAssociativeArray(array $imageArray): Image
    {
        if (
            !isset($imageArray['id']) ||
            !isset($imageArray['name']) ||
            !isset($imageArray['image']) ||
            !isset($imageArray['discount_percentage'])
        ) {
            throw new InvalidImageAssociativeArrayException('Invalid array');
        }

        return self::createImage(
            $imageArray['id'],
            $imageArray['name'],
            $imageArray['image'],
            (float)$imageArray['discount_percentage'],
        );
    }

    /**
     * @param object $object
     * @return Image
     * @throws InvalidImageObjectException
     */
    public static function createImageFromObject(object $object): Image
    {
        if (
            !isset($object->id) ||
            !isset($object->name) ||
            !isset($object->image_url) ||
            !isset($object->discount_percentage)
        ) {
            throw new InvalidImageObjectException('Invalid object');
        }

        return self::createImage(
            $object->id,
            $object->name,
            $object->image_url,
            (float)$object->discount_percentage,
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $imageUrl
     * @param float $discountPercentage
     * @return Image
     */
    public static function createImage(
        string $id,
        string $name,
        string $imageUrl,
        float $discountPercentage
    ): Image {
        return new Image(
            $id,
            $name,
            $imageUrl,
            $discountPercentage
        );
    }
}
