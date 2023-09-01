<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="app_api_user", methods={"GET"})
     */
    public function getCurrentUser()
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
