<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Boardgame;
use App\Form\UserType;
use App\Repository\BoardgameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/user")
 * 
 */
class UserController extends AbstractController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/inscription", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->encoder->encodePassword($user, $user->getPassword())
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

    /**
     * @Route("/{id}/friendslist", name="friendslist", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function friendslist(User $user): Response
    {
        $friends = $user->getFriends();
        return $this->render('user/friendslist.html.twig', [
            'friends' => $friends,
            'user' =>$user
        ]);
    }

    /**
     * @Route("/{id}/boardgameslist", name="boardgameslist", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function boardgameslist(User $user, BoardgameRepository $boardgameRepository): Response
    {
        $favoriteGames = $user->getFavoriteGames();
        return $this->render('boardgame/boardgameslist.html.twig', [
            'friends' => $favoriteGames,
            'user' =>$user,
            'boardgames' => $boardgameRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/friendslist-add/{id}", name="friendslist_add", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function friendslist_add(User $user): Response
    {
        $currentUser = $this->getUser();
        $currentUser->addFriend($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app_index');

    }

     /**
     * @Route("/boardgames-add/{id}", name="boardgameslist_add", methods={"GET"})
     * @ParamConverter("id", options={"id": "id"})
     * @IsGranted("ROLE_USER")
     */
    public function boardgameslist_add(Boardgame $boardgame): Response
    {
        $currentUser = $this->getUser();
        $currentUser->addFavoriteGame($boardgame);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_index');

    }


    /**
     * @Route("/show/{id}", name="user_show", methods={"GET"})
     * @ParamConverter("id", options={"id": "id"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * 
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="user_delete", methods={"DELETE"})
     * @ParamConverter("id", options={"id": "id"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
    
}
