<?php

namespace App\Controller;

use App\Repository\ComicsRepository;
use App\Repository\CharactersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiComicsController extends AbstractController
{
    /**
     * @Route("/api/comics", name="app_api_comics")
     */
    public function listComics(ComicsRepository $comicsRepository): JsonResponse
    {
        // We retrieve the comics in the Database
        $comics = $comicsRepository->findAll();

        // we send a json response, with all the comics data, without the relation
        return $this->json($comics, Response::HTTP_OK, [], ["groups" => "comics"]);
    }
}
