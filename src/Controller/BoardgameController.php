<?php

namespace App\Controller;

use App\Entity\Boardgame;
use App\Form\BoardgameType;
use App\Repository\BoardgameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/boardgame")
 */
class BoardgameController extends AbstractController
{
    /**
     * @Route("/", name="boardgame_index", methods={"GET"})
     */
    public function index(BoardgameRepository $boardgameRepository): Response
    {
        return $this->render('boardgame/index.html.twig', [
            'boardgames' => $boardgameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="boardgame_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Boardgame $boardgame): Response
    {
        return $this->render('boardgame/show.html.twig', [
            'boardgame' => $boardgame,
        ]);
    }

}
