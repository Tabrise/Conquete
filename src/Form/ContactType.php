<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn-success']]);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();

            if (isset($data['tel'])) {
                $data['tel'] = $this->formatPhoneNumber($data['tel']);
                $event->setData($data);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
    public function formatPhoneNumber(string $phoneNumber): string
    {
        // Retirer tous les caractères non numériques pour nettoyer l'entrée
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Ajouter des points tous les deux chiffres
        return preg_replace('/(\d{2})(?=\d)/', '$1.', $cleaned);
    }
}
