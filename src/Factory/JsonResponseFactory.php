<?php

namespace App\Factory;

use App\Entity\ImagesCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponseFactory
 * @package App\Factory
 */
class JsonResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param ImagesCollection $imagesCollection
     * @param string $source
     * @return Response
     */
    public static function createImagesCollectionResponse(
        ImagesCollection $imagesCollection,
        string $source
    ): Response {
        return new JsonResponse([
            'count' => $imagesCollection->count(),
            'images' => $imagesCollection->getAll(),
            'source' => $source,
        ], 200);
    }

    /**
     * @param string $message
     * @param int|null $code
     * @return Response
     */
    public static function createErrorResponse(string $message, ?int $code = 500): Response
    {
        return new JsonResponse([
            'errors' => $message,
        ], $code);
    }
}
