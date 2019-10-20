<?php

namespace App\Handler;

use App\Command\GenerateImageListFileFromCsvCommand;
use App\Exception\FileDoesNotExistException;
use App\Exception\InvalidClassTypeException;
use App\Exception\InvalidInputFileFormatException;
use App\Exception\UnsupportedFileFormatException;
use App\Service\FileService;
use App\Service\ImageService;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class GenerateImageListFileFromCsvCommandHandler
 * @package App\Handler
 */
class GenerateImageListFileFromCsvCommandHandler implements MessageHandlerInterface
{
    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * @var FileService
     */
    private $fileService;
    /**
     * @var KernelInterface
     */
    private $appKernel;

    /**
     * GenerateImageListFileFromCsvCommandHandler constructor.
     * @param ImageService $imageService
     * @param FileService $fileService
     * @param KernelInterface $appKernel
     */
    public function __construct(ImageService $imageService, FileService $fileService, KernelInterface $appKernel)
    {
        $this->imageService = $imageService;
        $this->fileService = $fileService;
        $this->appKernel = $appKernel;
    }

    /**
     * @param GenerateImageListFileFromCsvCommand $command
     * @throws FileDoesNotExistException
     * @throws InvalidInputFileFormatException
     * @throws InvalidClassTypeException
     * @throws UnsupportedFileFormatException
     */
    public function __invoke(GenerateImageListFileFromCsvCommand $command): void
    {
        $images = $this->imageService->createImageArrayFromCsvFile(
            $command->getPath(),
        );

        $dir = $this->appKernel->getProjectDir() . '/var/files';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $filePath = $dir . '/images.' . $command->getFormat();
        $this->fileService->generateImagesListFile(
            $command->getFormat(),
            $filePath,
            $images,
        );
    }
}
