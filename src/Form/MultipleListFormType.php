<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\WordList;
use App\Form\DTO\MultipleListFormModel;
use App\Repository\WordListRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class MultipleListFormType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var WordListRepository
     */
    private $listRepository;
    
    public function __construct(Security $security, WordListRepository $listRepository)
    {
        $this->security = $security;
        $this->listRepository = $listRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();
        
        $builder
            ->add('lists', EntityType::class, [
                'class'    => WordList::class,
                'multiple' => true,
                'expanded' => true,
                'label'    => 'Доступные списки:',
                'choices'  => $this->listRepository->getListsByTrainingDate($currentUser),
            ])
            ->add('countFromList', TextType::class, [
                'attr'     => [
                    'value' => 10,
                ],
                'label'    => 'Количество слов из каждого списка:',
                'required' => true,
            ])
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
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MultipleListFormModel::class,
        ]);
    }
}
