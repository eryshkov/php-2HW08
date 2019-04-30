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
     * @Assert\Length(min="6", minMessage="Пароль должен быть не короче 6 символов")
     */
    public $plainPassword;
    /**
     * @var bool
     */
    public $rememberMe;
}
