<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\ComicsRepository;
use App\Repository\UserCollectionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiOwnListController extends AbstractController
{
    /**
     * Show the user collection (ownedlist)
     * @Route("/api/ownedlist", name="api_ownedlist", methods={"GET"})
     */
    public function getOwnedList(UserCollectionRepository $userCollectionRepository): JsonResponse
    {
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();
        
        // Récupérez la wishlist de l'utilisateur 
        $wishlist = $userCollectionRepository->findBy(['user' => $user]);
    
        return $this->json($wishlist, JsonResponse::HTTP_OK, [], ['groups' => 'ownedlist']);
    }

    /**
     * Add a comic to the "je possède" list
     * @Route("/api/own-list/add/{id}", name="api_own_list_add")
     * @param Comics $comics Comic to add to the "je possède" list
     */
    public function addToOwnList(Comics $comics): Response
    {
        // Add the comic to the user's "je possède" list (you need to implement this logic)

        return $this->json(['message' => 'Comic added to "je possède" list']);
    }

    /**
     * Remove a comic from the "je possède" list
     * @Route("/api/own-list/remove/{id}", name="api_own_list_remove")
     * @param Comics $comics Comic to remove from the "je possède" list
     */
    public function removeFromOwnList(Comics $comics): Response
    {
        // Remove the comic from the user's "je possède" list (you need to implement this logic)

        return $this->json(['message' => 'Comic removed from "je possède" list']);
    }
}
