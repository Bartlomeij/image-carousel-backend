<?php

namespace App\Controller;

use App\Factory\ResponseFactory;
use App\Filter\ImagesCollectionFilter;
use App\Service\ImageService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImageController
 * @package App\Controller
 */
class ImageController
{
    /**
     * @param ImageService $imageService
     * @param Request $request
     * @return Response
     *
     * @Route("/images", methods={"GET"}, name="get_images")
     */
    public function listImages(ImageService $imageService, Request $request): Response
    {
        $source = $request->get('source') ?? 'json';
        $responseFactory = ResponseFactory::chooseContentType($request->headers->get('Accept'));

        $imagesCollectionFilter = new ImagesCollectionFilter(
            trim($request->get('name')),
            (float)$request->get('discount_from'),
            (float)$request->get('discount_to'),
        );

        try {
            $images = $imageService->getImagesCollectionByFormat($source, $imagesCollectionFilter);
        } catch (Exception $exception) {
            return $responseFactory::createErrorResponse($exception->getMessage());
        }
        return $responseFactory::createImagesCollectionResponse($images, $source);
    }
}
