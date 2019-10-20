<?php

namespace App\Entity;

use App\Exception\InvalidClassTypeException;
use function PHPSTORM_META\type;

/**
 * Class AbstractImagesListFile
 * @package App\Entity
 */
abstract class AbstractImagesListFile
{
    /**
     * @var array
     */
    private $images = array();

    /**
     * @param Image $image
     */
    public function addImage(Image $image): void
    {
        $this->images[] = $image;
    }

    /**
     * @param Image[] $images
     * @throws InvalidClassTypeException
     */
    public function addImages(array $images): void
    {
        foreach ($images as $image) {
            if (!$image instanceof Image) {
                $type = getType($image);
                if ($type === 'object') {
                    $type = get_class($image);
                }

                throw new InvalidClassTypeException('Expected instance of ' . Image::class . ', ' . $type . ' passed');
            }
            $this->addImage($image);
        }
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param string $path
     */
    abstract public function save(string $path): void;
}
