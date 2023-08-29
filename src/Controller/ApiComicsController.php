<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\ComicsRepository;
use App\Repository\CharactersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiComicsController extends AbstractController
{
    /**
     * @Route("/api/comics", name="app_api_comics", methods={"GET"})
     */
    public function listComics(ComicsRepository $comicsRepository): JsonResponse
    {
        $comics = $comicsRepository->findAll();

        return $this->json($comics, Response::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }
    

     /**
     * @Route("/api/comics/{id}", name="app_api_comics_show", methods={"GET"})
     */
    public function showComics($id, ComicsRepository $comicsRepository): JsonResponse
    {
        $comics = $comicsRepository->find($id);

        if (!$comics) {
            return $this->json(['message' => 'Le comics n\'existe pas'], Response::HTTP_NOT_FOUND);
        }
    
        return $this->json($comics, JsonResponse::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }

    /**
     * @Route("/api/home-comics", name="app_api_comics", methods={"GET"})
     */
    public function homeComics(ComicsRepository $comicsRepository): JsonResponse
    {
        $comics = $comicsRepository->findNineComics();

        return $this->json($comics, Response::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }

    /**
     * @Route("/api/search-comics", name="api_search_comics")
     */
    public function searchComics(Request $request, ComicsRepository $comicsRepository): JsonResponse
    {
         // Retrieve the title of the comics
        $title = $request->query->get('title');

        // Use the custom query in order to do the search by title
        $comics = $comicsRepository->findAllOrderByTitleSearch($title);

        // Convert the array as a json
        $response = [];
        foreach ($comics as $comic) {
            $response[] = [
                'id' => $comic->getId(),
                'title' => $comic->getTitle(),
                'poster' => $comic->getPoster(),
                'synopsis' => $comic->getSynopsis(),
                'released_at' => $comic->getReleasedAt(),
            ];
        }

        return $this->json($response, Response::HTTP_OK, [], ['groups' => 'comics']);
    }
}
