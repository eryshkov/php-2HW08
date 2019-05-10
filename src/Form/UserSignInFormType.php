<?php

namespace App\Form;

use App\Form\DTO\UserSignInFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSignInFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr'     => [
                    'placeholder' => 'email',
                ],
                'label'    => false,
                'required' => true,
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr'     => [
                    'placeholder' => 'пароль',
                ],
                'label'    => false,
                'required' => true,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSignInFormModel::class,
        ]);
    }
}
