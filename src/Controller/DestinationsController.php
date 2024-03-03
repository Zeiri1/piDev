<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\AccommodationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DestinationsController extends AbstractController
{
    #[Route('/destinations', name: 'app_destinations')]
    public function index(AccommodationRepository $AccomRepo,Request $request): Response
    {
        $allAccoms = $AccomRepo->findAll();
        $form=$this->createForm(SearchFormType::class );
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $title=$form->get('title')->getData();
            $min=$form->get('min')->getData();
            $max=$form->get('max')->getData();
            if(empty($title)){
                $allAccoms=$AccomRepo->searchByMinMax($min , $max );
            }else if(empty($min) && (empty($max))){
                $allAccoms=$AccomRepo->searchByTitle($title );
            }else{
                $allAccoms=$AccomRepo->searchByTitleAndMinMax($title,$min , $max );
            }

        }

        return $this->render('destinations/index.html.twig', 
        ['Accommodations' => $allAccoms,
        'searchForm' => $form->createView()]);
    }

    #[Route('/destinations/{id}', name: 'show_accommodation')]
    public function showAccomodation($id, ManagerRegistry $manager, AccommodationRepository $AccomRepo): Response
    {
        $emm = $manager->getManager();
        $accommodation = $AccomRepo->find($id);
        $cat = $accommodation->getCategory();
        $cat->setStatistics($cat->getStatistics()+1);
        $emm->persist($cat);
        $emm->flush();

        return $this->render('destinations/detail.html.twig', 
        ['accommodation' => $accommodation]);
    }

}
