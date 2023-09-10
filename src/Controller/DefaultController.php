<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
/**
     * @Route("/{reactRouting}", name="react_routing", defaults={"reactRouting": null}, requirements={"reactRouting"=".+"})
     */
    public function index(): Response
    {
        // Remplacez cette partie par le chemin vers votre fichier index.html
        return $this->file('%kernel.project_dir%/public/index.php');
    }
}
