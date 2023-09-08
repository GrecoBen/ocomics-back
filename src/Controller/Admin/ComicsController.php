<?php

namespace App\Controller\Admin;

use App\Entity\Comics;
use App\Form\ComicsType;
use App\Repository\ComicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComicsController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_comics_list")
     * Homepage, display the list of all the comicss
     */
    public function index(ComicsRepository $comicsRepository, Request $request): Response
    {
        $allComics = $comicsRepository->findAllOrderByTitleSearch($request->get("search"));
        return $this->render('admin/comics/list.html.twig', [
            'allComics' => $allComics
        ]);
    }

    /**
     * @Route("/admin/comics/{id}", name="app_admin_comics_show", requirements={"id"="\d+"})
     * Homepage, display the selected comics
     */
    public function show(Comics $comics): Response
    {
        return $this->render('admin/comics/show.html.twig', [
            'comics' => $comics,
        ]);
    }

    /**
     * @Route("/admin/comics/add", name="app_admin_comics_add")
     * Display the form to add a new comics
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comics = new comics();
        $form = $this->createForm(comicsType::class, $comics);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comics);
            $entityManager->flush();
            $this->addFlash("success", "Comics ajouté avec succès!");
            return $this->redirectToRoute('app_admin_comics_list');
        } elseif ($form->isSubmitted()) {
            $this->addFlash("danger", "L'ajout du comics a échoué!");
        }

        return $this->renderForm("admin/comics/form.html.twig", [
            "form" => $form
        ]);
    }

    /**
     * @Route("/admin/comics/edit/{id}", name="app_admin_comics_edit", requirements={"id"="\d+"})
     * Display the form to edit a new comics
     */
    public function edit(Comics $comics, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(comicsType::class, $comics);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();
            $entityManager->persist($comics);

            $this->addFlash("success", "Le comics a bien été édité.");

            return $this->redirectToRoute('app_admin_comics_list');
        }

        return $this->renderForm("admin/comics/form.html.twig", [
            "form" => $form
        ]);
    }

    /**
     * @Route("/admin/comics/delete/{id}", name="app_admin_comics_delete", requirements={"id"="\d+"})
     */
    public function delete(Comics $comics, ComicsRepository $comicsRepository): Response
    {
        $comicsRepository->remove($comics, true);

        $this->addFlash("success", "Le comics a bien été supprimé.");

        return $this->redirectToRoute('app_admin_comics_list', [], Response::HTTP_SEE_OTHER);
    }
}
