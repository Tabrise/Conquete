<?php

namespace App\Form;

use App\Entity\Audit;
use App\Repository\QuestionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AuditType extends AbstractType
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $questions = $this->questionRepository->findBy(['utiliser' => true], ['ordre' => 'ASC']);

        foreach ($questions as $question) {
            $builder->add('response_' . $question->getId(), TextType::class, [
                'label' => "{$question->getOrdre()} - {$question->getIntitule()}",
                'mapped' => false,
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audit::class,
        ]);
    }
}
