<?php

namespace App\Controller;

use App\Form\UserSignInFormModel;
use App\Form\UserSignInFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $userModel = new UserSignInFormModel();
        if (isset($lastUsername)) {
            $userModel->email = $lastUsername;
        }
        $form = $this->createForm(UserSignInFormType::class, $userModel, [
            'attr' => [
                'novalidate' => null,
            ],
        ]);
    
        return $this->render('security/login.html.twig', [
            'signInForm' => $form->createView(),
            'authError' => $error,
        ]);
    }
    
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
