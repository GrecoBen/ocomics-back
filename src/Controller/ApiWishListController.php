<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\UserRepository;
use App\Repository\ComicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\WishCollectionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiWishListController extends AbstractController
{
    /**
     * Return the wishcollection (ownedlist) as a JSON
     * @Route("/api/wishlist", name="api_wishlist", methods={"GET"})
     */
    public function getWishList(WishCollectionRepository $wishCollectionRepository): JsonResponse
    {
        // Retrieve the current User
        $user = $this->getUser();
        
        // Retrieve the wishlist of the User
        $wishlist = $wishCollectionRepository->findBy(['user' => $user]);
    
        return $this->json($wishlist, JsonResponse::HTTP_OK, [], ['groups' => 'wishlist']);
    }

    /**
     * Add a comic to the user wishlist
     * @Route("/api/wishlist/add/{comicsId}", name="app_api_wishlist_add", methods={"POST"})
     * @param int $comicsId Comic ID to add to the ownlist of the current user
     */
    public function addToWishList(int $comicsId, EntityManagerInterface $entityManager, UserRepository $userRepository, ComicsRepository $comicsRepository): JsonResponse
    {
        // Retrieve the user with his ID
        //$user = $userRepository->find($userId);
        // Retrieve the current User
        $user = $this->getUser();
    
        // Retrieve the comics with his ID
        $comics = $comicsRepository->find($comicsId);
    
        if (!$user || !$comics) {
            return $this->json(['message' => 'Utilisateur ou comics inexistant.'], Response::HTTP_NOT_FOUND);
        }
    
        // add the comics to the wishCollection (the user wishlist) and save it in the database
        $wishCollection = $user->getWishCollection();
        $wishCollection->addComics($comics);
    
        $entityManager->persist($wishCollection);
        $entityManager->flush();
    
        return $this->json(['message' => 'Le comics a bien été ajouté à la liste des comics recherchés!']);
    }

    /**
     * Remove a comic from the user wishlist
     * @Route("/api/wishlist/remove/{comicsId}", name="app_api_wishlist_remove", methods={"DELETE"})
     * @param int $comicsId Comic ID to remove from the wishlist of the current user
     * @return JsonResponse
     */
    public function removeFromWishList(int $comicsId, EntityManagerInterface $entityManager, UserRepository $userRepository, ComicsRepository $comicsRepository): JsonResponse
    {
        // Retrieve the user with his ID
        //$user = $userRepository->find($userId);
        // Retrieve the current User
        $user = $this->getUser();

        // Retrieve the comics with his ID
        $comics = $comicsRepository->find($comicsId);

        if (!$user || !$comics) {
            return $this->json(['message' => 'Utilisateur ou comics inexistant.'], Response::HTTP_NOT_FOUND);
        }

        // Remove the comics from the wishCollection (the user wishlist) and save it in the database
        $wishCollection = $user->getWishCollection();
        $wishCollection->removeComics($comics);

        $entityManager->persist($wishCollection);
        $entityManager->flush();

        return $this->json(['message' => 'Le comics a bien été retiré de la liste des comics recherchés.']);
    }
}
