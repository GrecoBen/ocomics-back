<?php

namespace App\Controller;

use App\Entity\Characters;
use App\Repository\CharactersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiCharacterController extends AbstractController
{
    /**
     * @Route("/api/character", name="app_api_character")
     */
    public function listCharacters(CharactersRepository $charactersRepository, SerializerInterface $serializer): JsonResponse
    {
        $characters = $charactersRepository->findAll();

        $json = $serializer->serialize($characters, 'json', ['groups' => 'characters']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/character/{id}", name="app_api_character_show", methods={"GET"})
     */
    public function showCharacter(Characters $character, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($character, 'json', ['groups' => 'characters']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
