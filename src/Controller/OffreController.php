<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use Cloudinary\Cloudinary;
use App\Entity\Laboratoire;
use App\Form\SearchType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AccommodationRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OffreController extends AbstractController
{
    #[Route('/offre', name: 'app_offre')]
    public function index(): Response
    {
        
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }


    #[Route('/offre-add', name: 'add_offre')]
    public function addoffreform(): Response
    {
       
        return $this->render('offre\create.html.twig', [
            'errors' => null,
        ]);
    }

    #[Route('/offre-create', name: 'create_offre')]
    public function createoffreform(ValidatorInterface $validator, Request $request, ManagerRegistry $doctrine, AccommodationRepository $accommodationRepository): Response
    {

        $accomodation = $accommodationRepository->find(1);

        $imageFile = $request->files->get('image');
        $title = $request->get('title');
        $duration = $request->get('duration');
        $start = $request->get('startdate');
        $description = $request->get('description');
        $dateTime = new \DateTime($start);
        $offre = new Offre();

            $cloudinary = new Cloudinary([
                'cloud_name' => 'doux2fceo',
                'api_key' => '816942119146575',
                'api_secret' => 'svsG8w1pIHf0L58GLEUwH-3koN0',
            ]);


            $uploadResult = $cloudinary->uploadApi()->upload($imageFile->getPathname());

            $imageUrl = $uploadResult['secure_url'];
            $offre->setImage($imageUrl);
            $offre->setTitle($title);
            $offre->setDuration($duration);
            $offre->setStartdate($dateTime);
            $offre->setDescription($description);
            $offre->setAccomodation($accomodation);
            $errors = $validator->validate($offre);

            if (count($errors) > 0) {

                return $this->render('offre\create.html.twig', [
                    'errors' => $errors,
                ]);
            } else {
                $em = $doctrine->getManager();
                $em->persist($offre);
                $em->flush();
                return $this->redirectToRoute('show_offre');
            }
    }


    #[Route('/offre-edit/{id}', name: 'offre_edit')]
    public function editoffreform($id, OffreRepository $offreRepository): Response
    {
        $offre = $offreRepository->find($id);
        return $this->render('offre\edit.html.twig', [
            'offre' => $offre
        ]);
    }


    #[Route('/edit-offre-base/{id}', name: 'edit_offre_base')]
    public function editoffre($id, Request $request, ManagerRegistry $doctrine, OffreRepository $offreRepository): Response
    {

        $offre = $offreRepository->find($id);

        $title = $request->get('title');
        $duration = $request->get('duration');
        $start = $request->get('startdate');
        $description = $request->get('description');
        $dateTime = new \DateTime($start);

        if ($title && $duration && $start && $description) {
            $offre->setTitle($title);
            $offre->setDuration($duration);
            $offre->setStartdate($dateTime);
            $offre->setDescription($description);
            $em = $doctrine->getManager();
            $em->flush();
        }
        return $this->redirectToRoute('show_offre');
    }


    #[Route('/show-offre', name: 'show_offre')]
    public function showoffre(Request $request, OffreRepository $offreRepository): Response
    {

        $offres = $offreRepository->findAll();
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $datainput = $form->get('title')->getData();
            $offres = $offreRepository->searchoffre($datainput);
        }
        return $this->renderForm('offre\alloffres.html.twig', [
            'offres' => $offres,
            'f'=>$form,
        ]);
    
}

    #[Route('/book/delete/{id}', name: 'offre_delete')]
    public function deleteOffre(Request $request, $id, ManagerRegistry $manager, ReservationRepository $reservationRepository, OffreRepository $offreRepository): Response
    {

        $reservation = $reservationRepository->findOneBy(['offre' => $id]);
        $em = $manager->getManager();
        if ($reservation) {
            $em->remove($reservation);
            $em->flush();
        }
        $offre = $offreRepository->find($id);

        $em->remove($offre);
        $em->flush();

        return $this->redirectToRoute('show_offre');
    }


    #[Route('/offre/cloud/{id}', name: 'offre_cloud')]
    public function uploadImageintern(Request $request,$id, OffreRepository $offreRepository, ManagerRegistry $doctrine)
    {
        $offre = $offreRepository->find($id);
        $file = $request->files->get('image');
        $entityManager = $doctrine->getManager();

        if ($file) {

            $cloudinary = new Cloudinary([
                'cloud_name' => 'doux2fceo',
                'api_key' => '816942119146575',
                'api_secret' => 'svsG8w1pIHf0L58GLEUwH-3koN0',
            ]);


            $uploadResult = $cloudinary->uploadApi()->upload($file->getPathname());

            $imageUrl = $uploadResult['secure_url'];
            $offre->setImage($imageUrl);
            $entityManager->flush();

            return $this->redirectToRoute('show_offre');
        }
    }
}
