<?php

namespace App\Form;

use App\Entity\WordList;
use Symfony\Component\Validator\Constraints as Assert;

class WordEditFormModel
{
    /**
     * @Assert\NotBlank(message="Это поле не может быть пустым")
     * @var string
     */
    public $english;
    
    /**
     * @Assert\NotBlank(message="Это поле не может быть пустым")
     * @var string
     */
    public $russian;
    
    /**
     * @Assert\NotBlank(message="Это поле не может быть пустым")
     * @var WordList
     */
    public $list;
}
