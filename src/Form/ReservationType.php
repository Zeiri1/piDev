<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('datereservation')
            ->add('offre', EntityType::class, [
                'class' => Offre::class,
                'choice_label' => 'id',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
    private function getOffreChoices()
    {
        // Fetch the Offre choices from your database or another source
        // Replace this with the actual logic to get the Offre choices
        // For example, if using Doctrine, you might use the EntityManager to fetch Offre entities.

        // Assuming you have a repository for Offre entities:
        // $offreRepository = $this->getDoctrine()->getRepository(Offre::class);
        // $offres = $offreRepository->findAll();

        // For demonstration purposes, create some dummy Offre objects
        $offres = [
            new Offre('Offre 1'),
            new Offre('Offre 2'),
            // Add more Offre objects as needed
        ];

        return $offres;
    }
}
