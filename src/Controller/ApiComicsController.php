<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\ComicsRepository;
use App\Repository\CharactersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;



class ApiComicsController extends AbstractController
{
    /**
     * @Route("/api/comics", name="app_api_comics_list", methods={"GET"})
     */
    public function listComics(ComicsRepository $comicsRepository): JsonResponse
    {
        $comics = $comicsRepository->findAll();

        return $this->json($comics, Response::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }


    /**
     * @Route("/api/comics/{id}", name="app_api_comics_show", methods={"GET"})
     */
    public function showComics($id, ComicsRepository $comicsRepository): JsonResponse
    {
        $comics = $comicsRepository->find($id);

        if (!$comics) {
            return $this->json(['message' => 'Le comics n\'existe pas'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($comics, JsonResponse::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }

    /**
     * @Route("/api/home-comics", name="app_api_comics_home", methods={"GET"})
     */
    public function homeComics(ComicsRepository $comicsRepository): JsonResponse
    {
        $comics = $comicsRepository->findNineComics();

        return $this->json($comics, Response::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }

    /**
     * @Route("/api/search-comics", name="api_search_comics", methods={"GET"})
     */
    public function searchComics(Request $request, ComicsRepository $comicsRepository): JsonResponse
    {
        // Retrieve the title of the comics
        $title = $request->query->get('title');

        // Use the custom query in order to do the search by title
        $comics = $comicsRepository->findAllOrderByTitleSearch($title);

        // Convert the array as a json
        $response = [];
        foreach ($comics as $comic) {
            $response[] = [
                'id' => $comic->getId(),
                'title' => $comic->getTitle(),
                'poster' => $comic->getPoster(),
                'synopsis' => $comic->getSynopsis(),
                'released_at' => $comic->getReleasedAt(),
            ];
        }

        return $this->json($response, Response::HTTP_OK, [], ['groups' => 'comics']);
    }

    /**
     * Creation of a new comics
     * @Route("/api/admin/comics/add", name="app_api_admin_comics_add", methods={"POST"})
     */
    public function postComics(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    {
        // we retrieve a raw JSONN
        $jsonContent = $request->getContent();

        // serialize this JSON to transform it as an Entity
        try {
            $comics = $serializer->deserialize($jsonContent, Comics::class, 'json');
        } catch (NotEncodableValueException $e) {
            // in case the Json response is invalid
            return $this->json(["error" => "Le JSON n'est pas valide"], Response::HTTP_BAD_REQUEST);
        }

        // we check if there is any error in our entity 
        $errors = $validator->validate($comics);

        // if there is any errors, with send a JSON with the error
        if (count($errors) > 0) {

            // initialize a new error array
            $dataErrors = [];

            foreach ($errors as $error) {
                // in the array, we put at the index of the error, the error message
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }

            // return the JSON with the error
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // we use the entityManager to persist and flush the created comics
        $entityManager->persist($comics);

        $entityManager->flush();

        // we return a new JSON with the created comics, with the desired groups
        return $this->json([$comics], Response::HTTP_CREATED, [
            "Location" => $this->generateUrl("app_api_comics_show", ["id" => $comics->getId()])
        ], [
            "groups" => "comicsWithRelation"
        ]);
    }

    /**
     * Update a comics
     * @Route("/api/admin/comics/update/{id}", name="app_api_admin_comics_update", methods={"PUT"})
     */
    public function updateComics($id, Request $request, ComicsRepository $comicsRepository, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    {
        $comics = $comicsRepository->find($id);

        // If there is no comics with this id, with return a JSON with an error message
        if (!$comics) {
            return $this->json(['message' => 'Le comics n\'existe pas'], Response::HTTP_NOT_FOUND);
        }

        // Retrieve the raw JSON
        $jsonContent = $request->getContent();

        // Deserialize the JSON into the existing Comics object
        try {
            $serializer->deserialize($jsonContent, Comics::class, 'json', ['object_to_populate' => $comics]);
        } catch (NotEncodableValueException $e) {
            return $this->json(["error" => "Le JSON n'est pas valide"], Response::HTTP_BAD_REQUEST);
        }

        // we validate the updated Comics object
        $errors = $validator->validate($comics);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // we use the EntityManager to update the comics
        $entityManager->flush();

        return $this->json($comics, Response::HTTP_OK, [], ['groups' => 'comicsWithRelation']);
    }

    /**
     * Delete a comics
     * @Route("/api/admin/comics/delete/{id}", name="app_api_admin_comics_delete", methods={"DELETE"})
     */
    public function deleteComics($id, ComicsRepository $comicsRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $comics = $comicsRepository->find($id);

        if (!$comics) {
            return $this->json(['message' => 'Le comics n\'existe pas'], Response::HTTP_NOT_FOUND);
        }

        // we use the EntityManager to remove the comics
        $entityManager->remove($comics);
        $entityManager->flush();

        return $this->json(['message' => 'Le comics a été supprimé avec succès'], Response::HTTP_OK);
    }
}
