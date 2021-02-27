<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\BarType;
use App\Repository\BarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    /**
     * @Route("/", name="bar_index", methods={"GET"})
     * 
     */
    public function index(BarRepository $barRepository): Response
    {
        return $this->render('bar/index.html.twig', [
            'bars' => $barRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="bar_show", methods={"GET"})
     */
    public function show(Bar $bar): Response
    {
        return $this->render('bar/show.html.twig', [
            'bar' => $bar,
        ]);
    }

}
