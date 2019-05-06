<?php

namespace App\Form;

use App\Form\WordFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WordFormModel::class,
        ]);
    }
}
