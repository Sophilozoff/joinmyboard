<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/front")
 * @IsGranted("ROLE_USER")
 */
class FrontController extends AbstractController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/accueil", name="app_index")
     *
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
     * @Route("/subscription/{id}", name="front_sub_event")
     *
     * @return void
     */
    public function subscribe(Event $event){
        //on récupère l'utilisateur
        $user = $this->getUser();
        //On l'ajoute aux subscribers
        $event->addSubscriber($user);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', "Inscription réussie");
        return $this->redirectToRoute("app_index");
    }

    /**
     * @Route("/unsubscription/{id}", name="front_unsub_event")
     *
     * @return void
     */
    public function unSubscribe(Event $event){
        //on récupère l'utilisateur
        $user = $this->getUser();
        //On l'ajoute aux subscribers
        $event->removeSubscriber($user);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', "Vous êtes bien désinscrit");
        return $this->redirectToRoute("app_index");
    }

}
