<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpFormType;
use App\Form\UserRegistrationFormModel;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class SignUpController extends BaseController
{
    /**
     * @Route("/signup", name="app_sign_up")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @param GuardAuthenticatorHandler $guardAuthenticationHandler
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @return Response|null
     * @throws \Exception
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, GuardAuthenticatorHandler $guardAuthenticationHandler, LoginFormAuthenticator $loginFormAuthenticator): Response
    {
        $form = $this->createForm(SignUpFormType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserRegistrationFormModel $userModel */
            $userModel = $form->getData();
            $user = new User();
            $user->setEmail($userModel->email);
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $userModel->plainPassword)
            );
            $user->setRegDate(new \DateTime());
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            $successResponse = $guardAuthenticationHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $loginFormAuthenticator,
                'main');
            
            if (isset($successResponse)) {
                return $successResponse;
            }
        }
        
        return $this->render('sign_up/index.html.twig', [
            'signUpForm' => $form->createView(),
        ]);
    }
}
