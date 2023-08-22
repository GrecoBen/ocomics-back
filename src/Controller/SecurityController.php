<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return new JsonResponse([
            'fields' => [
                [
                    'name' => '_username',
                    'type' => 'text',
                    'label' => 'Username',
                    'required' => true,
                ],
                [
                    'name' => '_password',
                    'type' => 'password',
                    'label' => 'Password',
                    'required' => true,
                ],
            ],
        ]);
    }

    /**
     * @Route("/logout", name="app_security_logout")
     */
    public function logout()
    {
        // Symfony handles logout through this route
    }
}
