<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\WordList;
use App\Form\DTO\MultipleListFormModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class MultipleListFormType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();
        
        $builder
            ->add('lists', EntityType::class, [
                'class' => WordList::class,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Доступные списки:',
                'choices' => $currentUser->getWordLists(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MultipleListFormModel::class,
        ]);
    }
}
