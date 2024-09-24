<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Participation;
use App\Entity\ResearchProject;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntityType::class, ['class'=>Student::class, 'choice_label'=>'id'])
            ->add('researchProject', EntityType::class, ['class'=>ResearchProject::class, 'choice_label'=>'id'])
            ->add('startDate', DateTimeType::class, [
                'html5' => false,
                'widget' => 'single_text',
            ])
            ->add('estimatedEndDate', DateTimeType::class, [
                'html5' => false,
                'widget' => 'single_text',
            ])
            ->add('actualEndDate', DateTimeType::class, [
                'required' => false,
                'html5' => false,
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
