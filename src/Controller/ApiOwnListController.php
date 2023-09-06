<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comics;
use App\Entity\UserCollection;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\ComicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserCollectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiOwnListController extends AbstractController
{
    /**
     * Return the user collection (ownedlist) as a JSON
     * @Route("/api/ownedlist", name="app_api_ownedlist", methods={"GET"})
     */
    public function getOwnedList(UserCollectionRepository $userCollectionRepository): JsonResponse
    {
        // Retrieve the current User
        $user = $this->getUser();
        
        // Retrieve the ownedlist of the User
        $ownedlist = $userCollectionRepository->findBy(['user' => $user]);
    
        return $this->json($ownedlist, JsonResponse::HTTP_OK, [], ['groups' => 'ownedlist']);
    }

    /**
     * Add a comic to the user ownedlist
     * @Route("/api/ownedlist/add/{comicsId}", name="app_api_ownedlist_add", methods={"POST"})
     * @param int $comicsId Comic ID to add to the ownlist of the current user
     */
    public function addToOwnList(int $comicsId, EntityManagerInterface $entityManager, UserRepository $userRepository, ComicsRepository $comicsRepository): JsonResponse
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
    
        // add the comics to the userCollection (the user ownedlist) and save it in the database
        $userCollection = $user->getUserCollection();
        $userCollection->addComics($comics);
    
        $entityManager->persist($userCollection);
        $entityManager->flush();
    
        return $this->json(['message' => 'Le comics a bien été ajouté à la liste des comics possédés']);
    }

    /**
     * Remove a comic from the user ownedlist
     * @Route("/api/ownedlist/remove/{comicsId}", name="app_api_ownedlist_remove", methods={"DELETE"})
     * @param int $comicsId Comic ID to remove from the ownedlist of the current user
     * @return JsonResponse
     */
    public function removeFromOwnedList(int $comicsId, EntityManagerInterface $entityManager, UserRepository $userRepository, ComicsRepository $comicsRepository): JsonResponse
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

        // Remove the comics from the userCollection (the user ownedlist) and save it in the database
        $userCollection = $user->getUserCollection();
        $userCollection->removeComics($comics);

        $entityManager->persist($userCollection);
        $entityManager->flush();

        return $this->json(['message' => 'Le comics a bien été retiré de la liste des comics possédés.']);
    }
}
