<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class UserSignInFormModel
{
    /**
     * @Assert\NotBlank(message="Введите свой email")
     * @Assert\Email(message="Неверный email")
     */
    public $email;
    /**
     * @Assert\NotBlank(message="Введите свой пароль")
     */
    public $plainPassword;
}
