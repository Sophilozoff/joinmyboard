<?php

namespace App\Controller;

use App\Entity\Boardgame;
use App\Form\BoardgameType;
use App\Repository\BoardgameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/new", name="boardgame_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $boardgame = new Boardgame();
        $form = $this->createForm(BoardgameType::class, $boardgame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boardgame);
            $entityManager->flush();

            return $this->redirectToRoute('boardgame_index');
        }

        return $this->render('boardgame/new.html.twig', [
            'boardgame' => $boardgame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boardgame_show", methods={"GET"})
     */
    public function show(Boardgame $boardgame): Response
    {
        return $this->render('boardgame/show.html.twig', [
            'boardgame' => $boardgame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="boardgame_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Boardgame $boardgame): Response
    {
        $form = $this->createForm(BoardgameType::class, $boardgame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boardgame_index');
        }

        return $this->render('boardgame/edit.html.twig', [
            'boardgame' => $boardgame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boardgame_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Boardgame $boardgame): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boardgame->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boardgame);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boardgame_index');
    }
}
