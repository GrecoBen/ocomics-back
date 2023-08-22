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
    public function listComics(ComicsRepository $comicsRepository, CharactersRepository $charactersRepository): JsonResponse
    {
        $comics = $comicsRepository->findAll();
    
        $comicsData = [];
        foreach ($comics as $comic) {
            $charactersData = [];
            foreach ($comic->getCharacters() as $character) {
                $charactersData[] = [
                    'alias' => $character->getAlias(),
                    'name' => $character->getName(),
                    'released_at' => $character->getReleasedAt()->format('Y-m-d'),
                ];
            }
    
            $comicsData[] = [
                'title' => $comic->getTitle(),
                'poster' => $comic->getPoster(),
                'released_at' => $comic->getReleasedAt()->format('Y-m-d'),
                'synopsis' => $comic->getSynopsis(),
                'rarity' => $comic->getRarity(),
                'author' => [
                    'firstname' => $comic->getAuthor()->getFirstname(),
                    'lastname' => $comic->getAuthor()->getLastname(),
                ],
                'characters' => $charactersData,
            ];
        }
    
        return new JsonResponse($comicsData);
    }
}
