<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MarvelApiUrlGenerator;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

class MarvelController extends AbstractController
{
    /**
     * @Route("/marvel", name="app_marvel")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'MarvelController',
        ]);
    }

    /**
     * @Route("/get-marvel-info")
     */
    public function getMarvelInfo(MarvelApiUrlGenerator $urlGenerator): Response
    {
        // Specify the character name for which to retrieve information
        $characterName = "Hulk";

        // Generate the URL for character information using the provided service
        $url = $urlGenerator->generateCharacterUrl($characterName);

        // Create an HTTP client instance
        $httpClient = HttpClient::create();

        // Send a GET request to the generated URL
        $response = $httpClient->request('GET', $url);

        // Convert the JSON response to a PHP array
        $data = $response->toArray();

        // Now you can process the received Marvel API data
        // $data contains Marvel API information

        // Create a response with the retrieved data
        $responseContent = json_encode($data, JSON_PRETTY_PRINT);
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/get-marvel-comics")
     */
    public function getMarvelComics(Request $request, MarvelApiUrlGenerator $urlGenerator): Response
    {
        // Retrieve the page number from the query parameters
        $page = $request->query->getInt('page', 1);

        // Define the limit of items per page
        $limit = 30;

        // Calculate the offset based on the page number
        $offset = ($page - 1) * $limit;

        // Generate the URL for comics information using the provided service
        $url = $urlGenerator->generateComicsUrl($limit, $offset);

        // Create an HTTP client instance
        $httpClient = HttpClient::create();

        // Send a GET request to the generated URL
        $response = $httpClient->request('GET', $url);

        // Convert the JSON response to a PHP array
        $data = $response->toArray();

        // Retrieve the comics data
        $marvelComics = $data['data']['results'];

        // Create a response with the retrieved data
        $responseContent = json_encode($data, JSON_PRETTY_PRINT);
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/get-random-marvel-comics")
     */
    public function getRandomMarvelComics(Request $request, MarvelApiUrlGenerator $urlGenerator): Response
    {
        // Define the limit of items to retrieve
        $limit = 50; 

        // Generate the URL for comics information using the provided service
        $url = $urlGenerator->generateComicsUrl($limit);

        // Create an HTTP client instance
        $httpClient = HttpClient::create();

        // Send a GET request to the generated URL
        $response = $httpClient->request('GET', $url);

        // Convert the JSON response to a PHP array
        $data = $response->toArray();

        // Retrieve the comics data
        $marvelComics = $data['data']['results'];

        // Shuffle the array of comics randomly
        shuffle($marvelComics);

        // Extract random comic titles and their thumbnail URLs
        $randomComicData = [];
        for ($i = 0; $i < $limit; $i++) {
            if (isset($marvelComics[$i]['title']) && isset($marvelComics[$i]['thumbnail']['path']) && isset($marvelComics[$i]['thumbnail']['extension'])) {
                $comicTitle = $marvelComics[$i]['title'];
                $thumbnailUrl = $marvelComics[$i]['thumbnail']['path'] . '.' . $marvelComics[$i]['thumbnail']['extension'];
                $randomComicData[] = [
                    'title' => $comicTitle,
                    'thumbnail' => $thumbnailUrl,
                ];
            }
        }

        // Create a response with the random comic data
        $responseContent = json_encode($randomComicData, JSON_PRETTY_PRINT);
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }
}
