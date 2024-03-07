<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType; 

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [ 
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 10,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom ne peut pas comporter plus de {{ limit }} caractères',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom ne doit contenir que des lettres.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ecrire votre prénom',
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom ne peut pas être vide']),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le prénom ne peut pas comporter plus de {{ limit }} caractères',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le prénom ne doit contenir que des lettres.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ecrire votre prénom',
                ],
            ])
            ->add('duration')
            ->add('startdate')
            ->add('accomodation');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
