<?php

namespace App\Security;

use App\Entity\User;
use App\Form\UserSignInFormModel;
use App\Form\UserSignInFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;
    
    private $entityManager;
    private $urlGenerator;
    private $passwordEncoder;
    private $formFactory;
    
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, UserPasswordEncoderInterface $passwordEncoder, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->passwordEncoder = $passwordEncoder;
        $this->formFactory = $formFactory;
    }
    
    public function supports(Request $request): bool
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }
    
    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(UserSignInFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserSignInFormModel $userModel */
            $userModel = $form->getData();
            
            $request->getSession()->set(
                Security::LAST_USERNAME,
                $userModel->email
            );
            
            return $userModel;
        }
        
        throw new CustomUserMessageAuthenticationException('Неверный логин/пароль');
    }
    
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var UserSignInFormModel $credentials */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials->email]);
        
        if (!isset($user)) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Пользователь не существует');
        }
        
        return $user;
    }
    
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        /** @var UserSignInFormModel $credentials */
        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $credentials->plainPassword);
        
        if (!$isPasswordValid) {
            throw new CustomUserMessageAuthenticationException('Неверный пароль');
        }
        
        return $isPasswordValid;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        
        return new RedirectResponse($this->urlGenerator->generate('app_lists'));
    }
    
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('app_login');
    }
}
