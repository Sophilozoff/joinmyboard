<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Entity\Boardgame;
use App\Form\BarType;
use App\Form\BoardgameType;
use App\Repository\BarRepository;
use App\Repository\BoardgameRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
     * @Route("/admin")
     * @IsGranted("ROLE_ADMIN")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/accueil", name="admin_index")
     */
    public function index(UserRepository $userRepository,
    EventRepository $eventRepository): Response
    {
        return $this->render('admin/index_admin.html.twig', [
            'countAllUsers' => $userRepository->countById(),
            'countAllEvents' => $eventRepository->countById()
        ]);
    }

    /**
     * @Route("/bar/index", name="admin_bar_index", methods={"GET"})
     * 
     */
    public function bars(BarRepository $barRepository): Response
    {
        return $this->render('admin/bar/index.html.twig', [
            'bars' => $barRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/bar/nouveau-bar", name="bar_new", methods={"GET","POST"})
     */
    public function new_bar(Request $request): Response
    {
        $bar = new Bar();
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bar);
            $entityManager->flush();

            return $this->redirectToRoute('bar_index');
        }

        return $this->render('admin/bar/new.html.twig', [
            'bar' => $bar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bar/{id}", name="bar_show", methods={"GET"})
     * @ParamConverter("bar", options={"id" = "bar_id"})
     */
    public function show(Bar $bar): Response
    {
        return $this->render('admin/bar/show.html.twig', [
            'bar' => $bar,
        ]);
    }
    
    /**
     * @Route("/bar/{id}/bar-edit", name="bar_edit", methods={"GET","POST"})
     * @ParamConverter("bar", options={"id" = "bar_id"})
     */
    public function bar_edit(Request $request, Bar $bar): Response
    {
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_bar_index');
        }

        return $this->render('admin/bar/edit.html.twig', [
            'bar' => $bar,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/bars/{id}", name="bar_delete", methods={"DELETE"})
     * @ParamConverter("bar", options={"id" = "bar_id"})
     */
    public function bar_delete(Request $request, Bar $bar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_bar_index');
    }
    /**
     * @Route("/jeux", name="admin_boardgame_index", methods={"GET"})
     */
    public function boardgames(BoardgameRepository $boardgameRepository): Response
    {
        return $this->render('admin/boardgame/index.html.twig', [
            'boardgames' => $boardgameRepository->findAll(),
        ]);
    }
    /**
     * @Route("/nouveau-jeu", name="boardgame_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('admin_boardgame_index');
        }

        return $this->render('admin/boardgame/new.html.twig', [
            'boardgame' => $boardgame,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/boardgames/{id}/boardgame-edit", name="boardgame_edit", methods={"GET","POST"})
     * @ParamConverter("boardgame", options={"id" = "boardgame_id"})
     */
    public function boardgame_edit(Request $request, Boardgame $boardgame): Response
    {
        $form = $this->createForm(BoardgameType::class, $boardgame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_boardgame_index');
        }

        return $this->render('admin/boardgame/edit.html.twig', [
            'boardgame' => $boardgame,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/boardgames/{id}", name="admin_boardgame_delete", methods={"DELETE"})
     * @ParamConverter("boardgame", options={"id" = "boardgame_id"})
     */
    public function boardgame_delete(Request $request, Boardgame $boardgame): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boardgame->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boardgame);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_boardgame_index');
    }

}
