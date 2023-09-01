<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $serializer;
    private $passwordHasher;

    public function __construct(SerializerInterface $serializer, UserPasswordHasherInterface $passwordHasher)
    {
        $this->serializer = $serializer;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/api/register", name="app_api_register", methods={"POST"})
     */
    public function register(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    { 

        $newUser = new User();
        try {
            $userData = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        } catch (NotEncodableValueException $e) {
            return $this->json(["error" => "Invalid json"], Response::HTTP_BAD_REQUEST);
        }

        $plainPassword = $userData->getPassword();

        $newUser->setEmail($userData->getEmail());
        $newUser->setRoles(['ROLE_USER']);
        $newUser->setPassword($this->passwordHasher->hashPassword($userData, $plainPassword));
        $newUser->setFirstname($userData->getFirstname());
        $newUser->setLastname($userData->getLastname());

        $errors = $validator->validate($newUser, null, ["registration"]);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($newUser);
        $entityManager->flush();

        return $this->json([$newUser], Response::HTTP_CREATED, [
            "Location" => $this->generateUrl("app_api_user_get", ["id" => $newUser->getId()])
        ], ["groups" => "user"]);
    }
}
