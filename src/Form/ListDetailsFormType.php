<?php

namespace App\Form;

use App\Form\ListDetailsFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListDetailsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isShowTranslation', ChoiceType::class, [
                'choices' => [
                    'Оригинал' => true,
                    'Перевод' => false,
                ],
                'label' => 'Что показывать?',
            ])
            ->add('isRandom', ChoiceType::class, [
                'choices' => [
                    'Да' => true,
                    'Нет' => false,
                ],
                'label' => 'Показывать в случайном порядке?',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListDetailsFormModel::class,
        ]);
    }
}
