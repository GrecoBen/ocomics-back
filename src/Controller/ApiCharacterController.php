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
    public function listCharacters(CharactersRepository $charactersRepository): JsonResponse
    {
        $characters = $charactersRepository->findAll();

        return $this->json($characters, Response::HTTP_OK, [], ['groups' => 'charactersWithRelation']);
    }

    /**
     * @Route("/api/character/{id}", name="app_api_character_show", methods={"GET"})
     */
    public function showCharacter(int $id, CharactersRepository $charactersRepository): JsonResponse
    {
        $character = $charactersRepository->find($id);
    
        if (!$character) {
            return $this->json(['message' => 'Le personnage n\'existe pas'], Response::HTTP_NOT_FOUND);
        }
    
        return $this->json($character, Response::HTTP_OK, [], ['groups' => 'charactersWithRelation']);
    }
}
