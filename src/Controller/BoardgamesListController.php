<?php

namespace App\Controller;

use App\Entity\BoardgamesList;
use App\Entity\Boardgame;
use App\Repository\BoardgamesListRepository;
use App\Repository\BoardgameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoardgamesListController extends AbstractController
{
    /**
     * @Route("/ludotheque/", name="boardgames_list")
     */
    public function index(): Response
    {
        return $this->render('boardgames_list/index.html.twig', [
            'controller_name' => 'BoardgamesListController',
        ]);
    }
}
