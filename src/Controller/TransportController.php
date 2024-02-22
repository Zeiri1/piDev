<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;

class TransportController extends AbstractController
{
    #[Route('/transport', name: 'app_transport')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TransportController.php',
        ]);
    }
}
