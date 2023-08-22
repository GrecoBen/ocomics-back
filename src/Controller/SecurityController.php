<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("api/login", name="app_security_login")
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
     * @Route("api/logout", name="app_security_logout")
     */
    public function logout()
    {
        // Symfony handles logout through this route
    }

    /**
     * @Route("api/register", name="app_security_register")
     */
    public function registerForm(): JsonResponse
    {
        return new JsonResponse([
            'fields' => [
                [
                    'name' => 'firstname',
                    'type' => 'text',
                    'label' => 'First Name',
                    'required' => true,
                ],
                [
                    'name' => 'lastname',
                    'type' => 'text',
                    'label' => 'Last Name',
                    'required' => true,
                ],
                [
                    'name' => 'username',
                    'type' => 'text',
                    'label' => 'Username',
                    'required' => true,
                ],
                [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Email',
                    'required' => true,
                ],
                [
                    'name' => 'password',
                    'type' => 'password',
                    'label' => 'Password',
                    'required' => true,
                ],
            ],
        ]);
    }
}
