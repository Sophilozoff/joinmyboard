<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\BarType;
use App\Repository\BarRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


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
     * @Route("/bar", name="admin_bar_index", methods={"GET"})
     * 
     */
    public function bars(BarRepository $barRepository): Response
    {
        return $this->render('admin/bar/index.html.twig', [
            'bars' => $barRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new", name="bar_new", methods={"GET","POST"})
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
     * @Route("/{id}/edit", name="bar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bar $bar): Response
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
     * @Route("/{id}", name="bar_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bar $bar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_bar_index');
    }
}
