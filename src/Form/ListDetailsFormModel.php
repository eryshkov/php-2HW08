<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ListDetailsFormModel
{
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
     * @var int
     */
    public $listId;
}
