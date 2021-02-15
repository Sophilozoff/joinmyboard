<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->render('admin/index.html.twig', [
            'countAllUsers' => $userRepository->countById(),
            'countAllEvents' => $eventRepository->countById()
        ]);
    }
}
