<?php

namespace App\Controller;

use App\Repository\AccommodationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccommodationAdminController extends AbstractController
{
    #[Route('/admin/accommodation', name: 'adminShowAccommodation')]
    public function showAccommodations(AccommodationRepository $AccomRepo)
    {

        $allAccoms = $AccomRepo->findAll();
        return $this->render('accommodation/admin/index.html.twig', 
        ['Accommodations' => $allAccoms]
    );
    }
     #[Route('/admin/accommodation/delete/{id}', name: 'adminDeleteAccommodation')]
    public function deleteAccommodation($id, ManagerRegistry $manager, AccommodationRepository $AccomRepo): Response
    {
       $emm = $manager->getManager();
       $id_remove = $AccomRepo->find($id);
       $emm->remove($id_remove);
       $emm->flush();


       return $this->redirectToRoute('adminShowAccommodation');
    }

}
