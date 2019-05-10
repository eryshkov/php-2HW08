<?php

namespace App\Form;

use App\Form\DTO\WordFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('english', TextareaType::class, [
                'attr'     => [
                    'placeholder' => 'английский вариант',
                ],
                'label'    => false,
                'required' => true,
            ])
            ->add('russian', TextareaType::class, [
                'attr'     => [
                    'placeholder' => 'русский вариант',
                ],
                'label'    => false,
                'required' => true,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WordFormModel::class,
        ]);
    }
}
