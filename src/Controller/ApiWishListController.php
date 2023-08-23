<?php

namespace App\Controller;

use App\Entity\Comics;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiWishListController extends AbstractController
{
    /**
     * @Route("/api/wish-list", name="api_wish_list")
     */
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'Welcome to the "je recherche" list API']);
    }

    /**
     * Add a comic to the "je recherche" list
     * @Route("/api/wish-list/add/{id}", name="api_wish_list_add")
     */
    public function addToWishList(Comics $comics): JsonResponse
    {
        // Ajoutez la logique pour ajouter le comics à la liste "je recherche"

        return $this->json(['message' => 'Comic added to "je recherche" list']);
    }

    /**
     * Remove a comic from the "je recherche" list
     * @Route("/api/wish-list/remove/{id}", name="api_wish_list_remove")
     */
    public function removeFromWishList(Comics $comics): JsonResponse
    {
        // Ajoutez la logique pour supprimer le comics de la liste "je recherche"

        return $this->json(['message' => 'Comic removed from "je recherche" list']);
    }
}
