<?php

namespace App\Command;

/**
 * Class GenerateImageListFileFromCsvCommand
 * @package App\Message
 */
class GenerateImageListFileFromCsvCommand
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $path;

    /**
     * GenerateImageListFileFromCsvCommand constructor.
     * @param string $format
     * @param string $path
     */
    public function __construct(string $format, string $path)
    {
        $this->format = $format;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
