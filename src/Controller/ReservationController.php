<?php

namespace App\Controller;

use App\Service\Mail;

use App\Entity\Reservation;
use App\Form\ReservationType;

use App\Repository\OffreRepository;
use App\Repository\ReservationRepository;
use App\Service\MailService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{

    private $emailService;

    public function __construct(MailService $emailService)
    {
        $this->emailService = $emailService;
    }


    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    #[Route('/add-reservation', name: 'add-reservation')]
    public function addReservation(Request $request, ManagerRegistry $doctrine): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Redirect to a success page or any other action
            return $this->redirectToRoute('success_page');
        }

        return $this->render('reservation/your_template.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/reservation-add/{id}', name: 'add_reservation')]
    public function addreservationform($id): Response
    {
        return $this->render('reservation\createreservation.html.twig', [
            'id' => $id
        ]);
    }


    #[Route('/reservation-create/{id}', name: 'create_reservation')]
    public function createreservationform($id, OffreRepository $offreRepository, Request $request, ReservationRepository $reservationRepository, ManagerRegistry $doctrine): Response
    {



        $offre = $offreRepository->find($id);
        $nombreplace = $request->get('nombreplace');

        $currentTime = new \DateTime();

        $reservation = new Reservation();
        $mailto = 'jihed.zeiri@esprit.tn';
        $message= 'your reservation done';

        if ($nombreplace) {

            $reservation->setNombreplace($nombreplace);
            $reservation->setDatereservation($currentTime);
            $reservation->setOffre($offre);
            $em = $doctrine->getManager();
            $this->emailService->sendDemandEmail($mailto, $message);
            $em->persist($reservation);
            $em->flush();
        }
        $reservations = $reservationRepository->findAll();
        return $this->redirectToRoute('show_reservation');
    }


    #[Route('/reservation-edit/{id}', name: 'reservation_edit')]
    public function editreservationform($id, ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->find($id);
        return $this->render('reservation\edit.html.twig', [
            'reservation' => $reservation
        ]);
    }


    #[Route('/edit-reservation-base/{id}', name: 'edit_reservation_base')]
    public function editreservation($id, Request $request, ManagerRegistry $doctrine, ReservationRepository $reservationRepository): Response
    {

        $reservation = $reservationRepository->find($id);

        $nombreplace = $request->get('nombreplace');


        if ($nombreplace) {
            $reservation->setNombreplace($nombreplace);

            $em = $doctrine->getManager();
            $em->flush();
        }
        $reservations = $reservationRepository->findAll();
        return $this->redirectToRoute('show_reservation', [
            'reservations' => $reservations,
        ]);
    }


    #[Route('/reservation/delete/{id}', name: 'reservation_delete')]
    public function deletrservation(Request $request, $id, ManagerRegistry $manager, ReservationRepository $reservationRepository): Response
    {
        $em = $manager->getManager();

        $reservation = $reservationRepository->find($id);

        $em->remove($reservation);
        $em->flush();
        $reservations = $reservationRepository->findAll();
        return $this->redirectToRoute('show_reservation', [
            'reservations' => $reservations,
        ]);
    }


    #[Route('/show-reservation', name: 'show_reservation')]
    public function showreservation(Request $request, OffreRepository $offreRepository, ReservationRepository $reservationRepository): Response
    {

        $reservations = $reservationRepository->findAll();

        return $this->render('reservation\allreservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    #[Route('/show-reservation/{title}', name: 'app_showreservation')]
    public function showauthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name
        ]);
    }
}
