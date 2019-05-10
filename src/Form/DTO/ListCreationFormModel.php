<?php

namespace App\Form\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ListCreationFormModel
{
    /**
     * @Assert\NotBlank(message="Имя не может быть пустым")
     * @var string
     */
    public $name;
}
