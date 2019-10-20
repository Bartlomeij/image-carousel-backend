<?php


namespace App\Service;

use App\Entity\Image;
use App\Exception\FileDoesNotExistException;
use App\Exception\InvalidImageAssociativeArrayException;
use App\Exception\InvalidInputFileFormatException;
use App\Factory\FileFactory;
use App\Factory\ImageFactory;

class ImageService
{
    /**
     * @param string $filepath
     * @return Image[]
     * @throws FileDoesNotExistException
     * @throws InvalidInputFileFormatException
     */
    public function createImageArrayFromCsvFile(string $filepath): array
    {
        $images = [];
        $imagesAssociativeArray = FileFactory::createAssociativeArrayFromCsvFile($filepath);

        try {
            foreach ($imagesAssociativeArray as $imageRow) {
                $images[] = ImageFactory::createImageFromAssociativeArray($imageRow);
            }
        } catch (InvalidImageAssociativeArrayException $exception) {
            throw new InvalidInputFileFormatException(
                sprintf('File %s has wrong format. Expected "id,name,image,discount_percentage" format.', $filepath)
            );
        }
        return $images;
    }
}
