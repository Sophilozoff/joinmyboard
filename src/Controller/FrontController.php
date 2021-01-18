<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_index")
     * IsGranted("ROLE_USER", "ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }


}
