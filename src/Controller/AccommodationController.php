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
    #[Route('/accommodation/add', name: 'Accommodation_add')]
    public function AddAccommodation(ManagerRegistry $doctrine, Request $request): Response
    {
        $errorMessage = "";
        $Accommodation =new Accommodation();
        $form=$this->createForm(AccommodationFormType::class,$Accommodation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if(empty($form->get('Title')->getData())){
                $errorMessage = "Title is empty";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage
                ]);
            }
            if(empty($form->get('Adress')->getData())){
                $errorMessage = "Address is empty";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage
                ]);
            }
            if(!(is_float($form->get('Price')->getData()) && (floatval($form->get('Price')->getData())>0))){
                $errorMessage = "Please put a valid price";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage
                ]);
            }
            if(empty($form->get('Type')->getData())){
                $errorMessage = "Type is empty";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage
                ]);
            }
            $em= $doctrine->getManager();
            $em->persist($Accommodation);
            $em->flush();
            return $this-> redirectToRoute('app_accommodation');
        }
        return $this->render('accommodation/form.html.twig',[
            'formAccom'=>$form->createView(),
            'errorMessage'=>$errorMessage
        ]);
    }
     #[Route('/accommodation/delete/{id}', name: 'deleteAccommodation')]
    public function deleteAccommodation($id, ManagerRegistry $manager, AccommodationRepository $AccomRepo): Response
    {
       $emm = $manager->getManager();
       $id_remove = $AccomRepo->find($id);
       $emm->remove($id_remove);
       $emm->flush();


       return $this->redirectToRoute('app_accommodation');
    }

    #[Route('/accommodation/edit/{id}', name: 'editAccommodation')]
    public function editAccommodation( $id,ManagerRegistry $manager, AccommodationRepository $AccomRepo, Request $request): Response
    {
        $em=$manager->getManager();
        $dataid=$AccomRepo->find($id);
       // var_dump($dataid).die() ;
        $form=$this->createForm(AccommodationFormType::class,$dataid) ;
        $form->handleRequest($request) ; 
 
        if($form->isSubmitted() and $form->isValid()){      //est ce que button qrass aaliha wela et est ceque les camps hatt'hom valid wela 
 
            $em->persist($dataid);                          //t'hadher requet INSERT
            $em->flush() ;                                   //execute 
            return $this->redirectToRoute('app_accommodation') ;
 
        }
 
        return $this->renderForm('accommodation/form.html.twig', [
            'formAccom' => $form,
        ]);
    }


}
