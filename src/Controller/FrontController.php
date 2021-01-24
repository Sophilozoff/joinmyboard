<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FrontController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_index")
     * @IsGranted("ROLE_USER")
     */
    public function index(EventRepository $eventRepository): Response
    {
        //Récupérer tous les events du plus vieux au plus lointain
        // $events = $eventRepository->findBy([], ["dateEvent"=>"ASC"]);
        $eventsPrev = $eventRepository->findPrevEvents();
        $eventsNext = $eventRepository->findNextEvents();
        

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'eventsNext' => $eventsNext,
            'eventsPrev' => $eventsPrev
        ]);
    }

    
    /**
     * @Route("/inscription", name="user_inscription", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword( 
                $this->encoder->encodePassword( $user, $user->getPassword() )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



}
