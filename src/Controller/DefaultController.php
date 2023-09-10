<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
/**
     * @Route("/{reactRouting}", name="react_routing", defaults={"reactRouting": null}, requirements={"reactRouting"=".+"})
     */
    public function index(): Response
    {
        $chemin =$this->getParameter('kernel.project_dir') .'/../projet-10-o-comicverse-front-v-2';
        if (!file_exists($chemin . '/index.html')){
            throw new FileNotFoundException('erreur');
        }
        // Remplacez cette partie par le chemin vers votre fichier index.html
        return $this->file($chemin . '/index.html');
    }
}
