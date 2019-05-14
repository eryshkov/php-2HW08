<?php

namespace App\Form\DTO;

use App\Entity\WordList;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MultipleListFormModel
{
    /**
     * @var WordList[]|ArrayCollection
     */
    public $lists = [];
    /**
     * @Assert\NotNull(message="Заполните это поле")
     * @var int
     */
    public $countFromList;
    /**
     * @Assert\NotNull(message="Сделайте выбор")
     * @var bool
     */
    public $isRandom;
    /**
     * @Assert\NotNull(message="Сделайте выбор")
     * @var bool
     */
    public $isShowTranslation;
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->lists->isEmpty()) {
            $context->buildViolation('Сделайте выбор')
                ->atPath('lists')
                ->addViolation();
        }
    }
}
