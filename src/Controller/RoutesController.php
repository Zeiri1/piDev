<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoutesController extends AbstractController
{
    // #[Route('/routes', name: 'app_routes')]
    // public function index(): Response
    // {
    //     return $this->render('routes/index.html.twig', [
    //         'controller_name' => 'RoutesController',
    //     ]);
    // }

    #[Route('/home', name: 'app_home')]
    public function homeFront(): Response
    {
        return $this->render('Front/static/home.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/homeback', name: 'app_homeBack')]
    public function homeBack(): Response
    {
        return $this->render('Back/home.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('Front/static/about.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function Contact(): Response
    {
        return $this->render('Front/static/contact.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }


    #[Route('/Auth', name: 'Auth')]
    public function auth(): Response
    {
        return $this->render('Front/Auth/Login.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('Front/Auth/Register.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/Dashboard', name: 'Dashboard')]
    public function Dashboard(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    
    #[Route('/Checkout', name: 'Checkout')]
    public function Checkout(): Response
    {
        return $this->render('Front/static/checkout.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
}
