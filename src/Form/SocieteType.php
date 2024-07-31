<?php

namespace App\Form;

use App\Entity\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('siret')
            ->add('adresse')
            ->add('ville')
            ->add('codePostal')
            ->add('numStandard')
            ->add('emailStandard')
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut Jurédique',
                'choices' => [
                    'SAS' => 'SAS',
                    'SARL' => 'SARL',
                    'SSII' => 'SSII'
                ]
            ])
            ->add('secteur', ChoiceType::class, [
                'label' => 'Secteur d\'Activité',
                'choices' => [
                    'Informatique' => 'Informatique',
                    'Commerce' => 'Commerce',
                    'Santé' => 'Santé',
                    'Industrie' => 'Industrie'
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire 0/75',
                'attr' => ['maxlength' => '75']
            ])
            ->add('contacts', CollectionType::class, [
                'entry_type' => ContactType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'required'=>false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }
}
