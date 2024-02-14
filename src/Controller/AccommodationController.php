<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Form\AccommodationFormType;
use App\Repository\AccommodationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccommodationController extends AbstractController
{
    #[Route('/accommodation', name: 'app_accommodation')]
    public function showAccommodations(AccommodationRepository $AccomRepo): Response
    {

        $allAccoms = $AccomRepo->findAll();
        return $this->render('accommodation/index.html.twig', 
        ['Accommodations' => $allAccoms]
    );
    }
    #[Route('/Accommodation/add', name: 'Accommodation_add')]
    public function AddAccommodation(ManagerRegistry $doctrine, Request $request): Response
    {
        $Accommodation =new Accommodation();
        $form=$this->createForm(AccommodationFormType::class,$Accommodation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($Accommodation);
            $em->flush();
            return $this-> redirectToRoute('app_accommodation');
        }
        return $this->render('accommodation/form.html.twig',[
            'formAccom'=>$form->createView(),
        ]);
    }
}
