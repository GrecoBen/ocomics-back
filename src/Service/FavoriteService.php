<?php


namespace App\Service;

use App\Entity\Comics;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavoriteService
{
    private $requestStack;
    private $maxFav;

    public function __construct(RequestStack $requestStack, int $maxFav)
    {
        $this->requestStack = $requestStack;
        $this->maxFav = $maxFav;
    }
}
