<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    
    #[Route('/', name: 'app_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,PaymentRepository $paymentRepository): Response
    {
        $payment2 = new Payment();
        $form = $this->createForm(PaymentType::class, $payment2);
        $form->handleRequest($request);


        $name =$request->request->get('FirstnameUser');
        $lname =$request->request->get('LastnameUser');
        $emailuser =$request->request->get('emailUser');
        $selectedOption = $request->request->get('option');
        
        if (($name !== null)&&($lname !== null)&&($emailuser !== null)) {
        $payment2->setFirstName($name);
        $payment2->setLastName($lname);
        $payment2->setEmail($emailuser);
        $payment2->setPaymentOptions($selectedOption);
        $payment2->setDate(new DateTime());

        $payment2->setAmount(500);


        $entityManager->persist($payment2);
        $entityManager->flush(); 
        
        //   $entityManager->persist($payment);
           // $entityManager->flush();

           return $this->redirectToRoute('app_payment_show', ['id' => $payment2->getId()], Response::HTTP_SEE_OTHER);
        }

       

        return $this->renderForm('payment/new.html.twig', [
            'payment' => $payment2,
            'form' => $form,
            
        ]);
    }

    #[Route('/{id}', name: 'app_payment_show', methods: ['GET'])]
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);

    }

    #[Route('/{id}/edit', name: 'app_payment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Payment $payment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payment_delete', methods: ['POST'])]
    public function delete(Request $request, Payment $payment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }

  
         
      #[Route("/payments", name:"payments")]
     
    public function in(PaymentRepository $paymentRepository): Response
    {
        $payments = $paymentRepository->findAllSortedByDate();

        return $this->render('payment/index.html.twig', [
            'payments' => $payments,
        ]);
    }
}
