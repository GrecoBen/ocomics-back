<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserCollection;
use App\Entity\WishCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiRegisterController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/register", name="app_api_register", methods={"POST"})
     */
    public function register(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        // deserialize and validate the JSON data
        $newUser = $this->serializer->deserialize($request->getContent(), User::class, 'json');

        // ...
        $userCollection = new UserCollection();
        $wishCollection = new WishCollection();
        // ...

        $errors = $validator->validate($newUser, null, ["registration"]);
    
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        // hashed password
        $plainPassword = $newUser->getPassword();
        $hashedPassword = $passwordHasher->hashPassword($newUser, $plainPassword);
        $newUser->setPassword($hashedPassword);
        // ...
        $newUser->setUserCollection($userCollection);
        $newUser->setWishCollection($wishCollection);
    
        $wishCollection->setUser($newUser);
        $userCollection->setUser($newUser);
        // ...
        $entityManager->persist($newUser);
        $entityManager->flush();
    
        return $this->json(['message' => 'Nouvel utilisateur créé.'], Response::HTTP_CREATED);
    }
}