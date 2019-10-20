<?php

namespace App\Service;

use App\Exception\InvalidClassTypeException;
use App\Exception\UnsupportedFileFormatException;
use App\Factory\FileFactory;

/**
 * Class FileService
 * @package App\Service
 */
class FileService
{
    /**
     * @param string $format
     * @param string $path
     * @param array $images
     * @throws InvalidClassTypeException
     * @throws UnsupportedFileFormatException
     */
    public function generateImagesListFile(string $format, string $path, array $images): void
    {
        $file = FileFactory::createFileFromImagesArray($format, $images);
        $file->save($path);
    }
}
