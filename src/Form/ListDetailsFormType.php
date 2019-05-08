<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListDetailsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isShowTranslation', ChoiceType::class, [
                'choices' => [
                    'Оригинал' => false,
                    'Перевод'  => true,
                ],
                'label'   => 'Что показывать?',
            ])
            ->add('isRandom', ChoiceType::class, [
                'choices' => [
                    'Да'  => true,
                    'Нет' => false,
                ],
                'label'   => 'Показывать в случайном порядке?',
            ])
            ->add('listId', HiddenType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListDetailsFormModel::class,
        ]);
    }
}
