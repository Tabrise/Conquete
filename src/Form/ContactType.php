<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('civilite', ChoiceType::class, [
                'choices' => ['Mr' => 'Mr', 'Mme' => 'Mme', 'Autres' => 'Autres'],
                'label' => '',
            ])
            ->add('poste')
            ->add('email')
            ->add('tel')
            ->add('commentaire', TextareaType::class, [
                'label' => 'Observation(optionnel):'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter', 'attr' => ['class' => 'btn-success']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
