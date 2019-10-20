<?php

namespace App\Factory;

use App\Entity\AbstractImagesListFile;
use App\Entity\ImagesListJsonFile;
use App\Entity\ImagesListXmlFile;
use App\Exception\FileDoesNotExistException;
use App\Exception\InvalidClassTypeException;
use App\Exception\UnsupportedFileFormatException;

/**
 * Class FileFactory
 * @package App\Factory
 */
class FileFactory
{
    public const JSON_FILE_TYPE = 'json';
    public const XML_FILE_TYPE = 'xml';

    /**
     * @param string $filepath
     * @return array
     * @throws FileDoesNotExistException
     */
    public static function createAssociativeArrayFromCsvFile(string $filepath): array
    {
        if (!file_exists($filepath)) {
            throw new FileDoesNotExistException(sprintf("File %s does not exist", $filepath));
        }

        $csv = array_map('str_getcsv', file($filepath));

        array_walk($csv, function (&$row) use ($csv) {
            $row = array_combine($csv[0], $row);
        });
        array_shift($csv);
        return $csv;
    }

    /**
     * @param string $format
     * @param array $images
     * @return AbstractImagesListFile
     * @throws InvalidClassTypeException
     * @throws UnsupportedFileFormatException
     */
    public static function createFileFromImagesArray(string $format, array $images): AbstractImagesListFile
    {
        switch (strtolower($format)) {
            case self::JSON_FILE_TYPE:
                $imagesListFile = new ImagesListJsonFile();
                break;
            case self::XML_FILE_TYPE:
                $imagesListFile = new ImagesListXmlFile();
                break;
            default:
                throw new UnsupportedFileFormatException(sprintf('Unsupported file format: %s', $format));
        }

        $imagesListFile->addImages($images);
        return $imagesListFile;
    }
}
