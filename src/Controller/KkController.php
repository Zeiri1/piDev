<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/kk')]
class KkController extends AbstractController
{
    #[Route('/', name: 'app_kk_index', methods: ['GET'])]
    public function index(TransportRepository $transportRepository): Response
    {
        return $this->render('kk/index.html.twig', [
            'transports' => $transportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_kk_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transport);
            $entityManager->flush();

            return $this->redirectToRoute('app_kk_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kk/new.html.twig', [
            'transport' => $transport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kk_show', methods: ['GET'])]
    public function show(Transport $transport): Response
    {
        return $this->render('kk/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_kk_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_kk_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kk/edit.html.twig', [
            'transport' => $transport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kk_delete', methods: ['POST'])]
    public function delete(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_kk_index', [], Response::HTTP_SEE_OTHER);
    }
}
