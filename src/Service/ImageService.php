<?php


namespace App\Service;

use App\Entity\Image;
use App\Entity\ImagesCollection;
use App\Exception\FileDoesNotExistException;
use App\Exception\InvalidImageAssociativeArrayException;
use App\Exception\InvalidImageObjectException;
use App\Exception\InvalidInputFileFormatException;
use App\Exception\UnsupportedFileFormatException;
use App\Factory\FileFactory;
use App\Factory\ImageCollectionFactory;
use App\Factory\ImageFactory;
use App\Filter\ImagesCollectionFilter;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ImageService
 * @package App\Service
 */
class ImageService
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * ImageService constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

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

    /**
     * @param string $format
     * @param ImagesCollectionFilter|null $imagesCollectionFilter
     * @return ImagesCollection
     * @throws FileDoesNotExistException
     * @throws InvalidImageObjectException
     * @throws UnsupportedFileFormatException
     */
    public function getImagesCollectionByFormat(
        string $format,
        ?ImagesCollectionFilter $imagesCollectionFilter = null
    ): ImagesCollection {
        switch (strtolower($format)) {
            case FileFactory::JSON_FILE_TYPE:
                $assocativeArray = FileFactory::createObjectsArrayFromJsonFile(
                    $this->projectDir . FileFactory::DEFAULT_JSON_FILE_PATH
                );
                break;
            case FileFactory::XML_FILE_TYPE:
                $assocativeArray = FileFactory::createObjectsArrayFromXmlFile(
                    $this->projectDir . FileFactory::DEFAULT_XML_FILE_PATH
                );
                break;
            default:
                throw new UnsupportedFileFormatException(sprintf('Unsupported file format: %s', $format));
        }

        return ImageCollectionFactory::createImageCollectionFromImageObjectsArray($assocativeArray, $imagesCollectionFilter);
    }
}
