<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\WordList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class WordEditFormType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;
    
    /**
     * WordEditFormType constructor.
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();
        
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
            ])
            ->add('list', EntityType::class, [
                'class'   => WordList::class,
                'label'   => 'Список',
                'choices' => $currentUser->getWordLists(),
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WordEditFormModel::class,
        ]);
    }
}
