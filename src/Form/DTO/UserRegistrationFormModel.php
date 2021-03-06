<?php

namespace App\Form\DTO;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Введите свой email")
     * @Assert\Email(message="Неверный email")
     * @UniqueUser(message="Пользователь {{ email }} уже существует")
     */
    public $email;
    /**
     * @Assert\NotBlank(message="Введите свой пароль")
     * @Assert\Length(min="6", minMessage="Пароль должен быть не короче 6 символов")
     */
    public $plainPassword;
    /**
     * @Assert\IsTrue(message="Нужно принять условия пользовательского соглашения")
     */
    public $agreeTerms;
}
