<?php

namespace App\Factory;

use App\Entity\ImagesCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ResponseFactoryInterface
 * @package App\Factory
 */
interface ResponseFactoryInterface
{
    /**
     * @param ImagesCollection $imagesCollection
     * @param string $source
     * @return Response
     */
    public static function createImagesCollectionResponse(
        ImagesCollection $imagesCollection,
        string $source
    ): Response;

    /**
     * @param string $message
     * @param int|null $code
     * @return Response
     */
    public static function createErrorResponse(string $message, ?int $code = 500): Response;
}
