<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'showCategory')]
    public function showCategory(CategoryRepository $CategoryRepo): Response
    {
        $allcategories = $CategoryRepo->findAll();
        return $this->render('category/index.html.twig', 
        ['Categories' => $allcategories]
    );
    }

    #[Route('/admin/category/form', name: 'Category_add')]
    public function AddCategory(ManagerRegistry $doctrine, Request $request): Response
    {
        $Category =new Category();
        $form=$this->createForm(CategoryFormType::class,$Category);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($Category);
            $em->flush();
            return $this-> redirectToRoute('showCategory');
        }
        return $this->render('Category/form.html.twig',[
            'formCategory'=>$form->createView(),
        ]);
    }
    #[Route('/admin/deleteCategory/{id}', name: 'deleteCategory')]
    public function deleteCategory($id, ManagerRegistry $manager, CategoryRepository $repo): Response
    {
        $emm = $manager->getManager();
        $nameremove = $repo->find($id);
        $emm->remove($nameremove);
        $emm->flush();


        return $this->redirectToRoute('showCategory');
    }
    #[Route('/admin/editCategory/{id}', name: 'editCategory')]
    public function editCategory( $id,ManagerRegistry $manager, CategoryRepository $CategoryRepo, Request $request): Response
    {
       $em=$manager->getManager();
       $dataId=$CategoryRepo->find($id);
      // var_dump($dataid).die() ;
       $form=$this->createForm(CategoryFormType::class,$dataId) ;
       $form->handleRequest($request) ; 

       if($form->isSubmitted() and $form->isValid()){      //est ce que button qrass aaliha wela et est ceque les camps hatt'hom valid wela 

           $em->persist($dataId);                          //t'hadher requet INSERT
           $em->flush() ;                                   //execute 
           return $this->redirectToRoute('showCategory') ;

       }

       return $this->render('Category/form.html.twig', [
         'formCategory'=>$form->createView(),
       ]);
   }
}
