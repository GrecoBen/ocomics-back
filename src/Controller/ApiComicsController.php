<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\ComicsRepository;
use App\Repository\CharactersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;


class ApiComicsController extends AbstractController
{
    /**
     * @Route("/api/comics", name="app_api_comics")
     */
    public function listComics(ComicsRepository $comicsRepository, SerializerInterface $serializer): JsonResponse
    {
        $comics = $comicsRepository->findAll();

        $json = $serializer->serialize($comics, 'json', ['groups' => 'comics']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

     /**
     * @Route("/api/comics/{id}", name="app_api_comics_show", methods={"GET"})
     */
    public function showComics(Comics $comic, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($comic, 'json', ['groups' => 'comics']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
