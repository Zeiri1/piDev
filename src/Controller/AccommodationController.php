<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Form\AccommodationFormType;
use App\Repository\AccommodationRepository;
use App\Repository\CategoryRepository;
use App\Services\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccommodationController extends AbstractController
{
    #[Route('/accommodation', name: 'app_accommodation')]
    public function showAccommodations(AccommodationRepository $AccomRepo)
    {

        $allAccoms = $AccomRepo->findAll();
        return $this->render('accommodation/index.html.twig', 
        ['Accommodations' => $allAccoms]
    );
    
    }
    #[Route('/accommodation/add', name: 'Accommodation_add')]
    public function AddAccommodation(ManagerRegistry $doctrine, 
    Request $request, CategoryRepository $categoryRepository,
    FileUploader $fileUploader): Response
    {
        $allCategories = $categoryRepository->findAll();
        $errorMessage = "";
        $Accommodation =new Accommodation();
        $form=$this->createForm(AccommodationFormType::class,$Accommodation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if(empty($form->get('Title')->getData())){
                $errorMessage = "Title is empty";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage,
                    'allCategories'=>$allCategories
                ]);
            }
            if(empty($form->get('address')->getData())){
                $errorMessage = "Address is empty";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage,
                    'allCategories'=>$allCategories
                ]);
            }
            if(!(is_float($form->get('Price')->getData()) && (floatval($form->get('Price')->getData())>0))){
                $errorMessage = "Please put a valid price";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage,
                    'allCategories'=>$allCategories
                ]);
            }
            if(empty($form->get('Type')->getData())){
                $errorMessage = "Type is empty";
                return $this->render('accommodation/form.html.twig',[
                    'formAccom'=>$form->createView(),
                    'errorMessage'=>$errorMessage,
                    'allCategories'=>$allCategories
                ]);
            }
            $ImageLink = $form->get('Image')->getData();
            if ($ImageLink) {
                $imageRef = $fileUploader->upload($ImageLink);
                $Accommodation->setImage($imageRef);
            }
            $em= $doctrine->getManager();
            $em->persist($Accommodation);
            $em->flush();
            return $this-> redirectToRoute('app_accommodation');
        }
        return $this->render('accommodation/form.html.twig',[
            'formAccom'=>$form->createView(),
            'errorMessage'=>$errorMessage,
            'allCategories'=>$allCategories
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
        $errorMessage = "";
        $form=$this->createForm(AccommodationFormType::class,$dataid) ;
        $form->handleRequest($request) ; 
 
        if($form->isSubmitted() and $form->isValid()){      //est ce que button qrass aaliha wela et est ceque les camps hatt'hom valid wela 
 
            $em->persist($dataid);                          //t'hadher requet INSERT
            $em->flush() ;                                   //execute 
            return $this->redirectToRoute('app_accommodation') ;
 
        }
 
        return $this->renderForm('accommodation/form.html.twig', [
            'formAccom' => $form,
            'errorMessage'=>$errorMessage,
        ]);
    }


}
