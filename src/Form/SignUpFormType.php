<?php

namespace App\Form;

use App\Form\UserRegistrationFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'email',
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('plainPassword', PasswordType::class,[
                'attr' => [
                    'placeholder' => 'пароль',
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'required' => true,
                'label' => 'Соглашаюсь с условиями',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationFormModel::class,
        ]);
    }
}
