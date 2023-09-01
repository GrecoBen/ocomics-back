<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="app_api_user", methods={"GET"})
     */
    public function getCurrentUser(?User $user): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non connecté'], 401);
        }

        $userData = [
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ];

        return $this->json($userData);
    }
}
