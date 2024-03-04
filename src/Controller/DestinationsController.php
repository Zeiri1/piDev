<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\AccommodationRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DestinationsController extends AbstractController
{
    #[Route('/destinations', name: 'app_destinations')]
    public function index(EntityManagerInterface $em,CategoryRepository $CategoryRepo, 
    PaginatorInterface $paginator, Request $request): Response
    {
        $query = $em->createQuery( "SELECT a FROM App\Entity\Accommodation a");
        $allCategories = $CategoryRepo->findAllOrderByStatistics();
        $form=$this->createForm(SearchFormType::class );
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $title=$form->get('title')->getData();
            $min=$form->get('min')->getData();
            $max=$form->get('max')->getData();
            if(empty($min)){
                $min=0;
            }
            if(!empty($title) && empty($min) && (empty($max))){
                $query = $em->createQuery('SELECT a from App\Entity\Accommodation a where a.Title LIKE :title' )
                ->setParameters(['title'=>'%'.$title.'%']) ;
            }else if(!empty($min) && !(empty($max)) && empty($title)){
                $query = $em->createQuery('SELECT a from App\Entity\Accommodation a where a.Price BETWEEN :min and :max ' )
                ->setParameters(['min'=>$min ,'max'=>$max]);
            }else if(!empty($min) && !(empty($max)) && !empty($title)){
                $query = $em->createQuery('SELECT a from App\Entity\Accommodation a where a.Title LIKE :title and a.Price BETWEEN :min and :max ' )
                ->setParameters(['title'=>'%'.$title.'%','min'=>$min ,'max'=>$max]);
            }

        }

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('destinations/index.html.twig', 
        ['Accommodations' => $pagination,
        'searchForm' => $form->createView(),
        'allCategories' => $allCategories]);
    }


    #[Route('/destinations/category/{id}', name: 'destinationByCategory')]
    public function destinationsByCategory($id, ManagerRegistry $manager, AccommodationRepository $AccomRepo,CategoryRepository $categoryRepo): Response
    {
        $allCategories = $categoryRepo->findAllOrderByStatistics();
        $emm = $manager->getManager();
        $category = $categoryRepo->findOneById($id);
        $accommodations = $AccomRepo->findAllByCategory($id);
        $category->setStatistics($category->getStatistics()+1);
        $emm->persist($category);
        $emm->flush();

        return $this->render('destinations/byCategories.html.twig',
        ['Accommodations' => $accommodations,'allCategories' => $allCategories]);
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
