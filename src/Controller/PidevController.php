<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PidevController extends AbstractController
{
    #[Route('/pidev', name: 'app_pidev')]
    public function index(): Response
    {
        return $this->render('pidev/index.html.twig', [
            'controller_name' => 'PidevController',
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        return $this->render('pidev/add.html.twig', [
            'controller_name' => 'PidevController',
        ]);
    }


}
