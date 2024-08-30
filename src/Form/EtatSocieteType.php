<?php

namespace App\Form;

use App\Entity\EtatSociete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EtatSocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('logo',  ChoiceType::class, [
                'choices' =>
                ['Envoi email' => 'bi bi-envelope-plus', 
                'Faire audit' => 'bi bi-clipboard2-plus', 
                'Fait' => 'bi bi-check-lg', 
                'Urgent' => 'bi bi-exclamation-lg', 
                'Croix' => 'bi bi-x-circle',
                'Alarm'=> 'bi bi-alarm',
            ],
                'label' => '',
            ])
            ->add('submit',SubmitType::class,['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatSociete::class,
        ]);
    }
}
