<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class WordFormModel
{
    /**
     * @Assert\NotBlank(message="Введите слово")
     */
    public $english;
    /**
     * @Assert\NotBlank(message="Введите слово")
     */
    public $russian;
}
