<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\WishCollectionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiWishListController extends AbstractController
{
    /**
     * Show the wish collection (wishlist)
     * @Route("/api/wishlist", name="api_wishlist", methods={"GET"})
     */
    public function getWishList(WishCollectionRepository $wishCollectionRepository): JsonResponse
    {
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();
        
        // Récupérez la wishlist de l'utilisateur 
        $wishlist = $wishCollectionRepository->findBy(['user' => $user]);
    
        return $this->json($wishlist, JsonResponse::HTTP_OK, [], ['groups' => 'wishlist']);
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
