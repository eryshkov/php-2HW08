<?php

namespace App\Form\DTO;

use App\Entity\WordList;
use Symfony\Component\Validator\Constraints as Assert;

class MultipleListFormModel
{
    /**
     * @Assert\NotNull(message="Сделайте выбор")
     * @var WordList[]
     */
    public $lists;
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
}
