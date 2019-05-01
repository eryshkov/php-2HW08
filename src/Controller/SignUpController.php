<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpFormType;
use App\Form\UserRegistrationFormModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class SignUpController
 * @IsGranted("not has_role('ROLE_USER')")
 */
class SignUpController extends AbstractController
{
    /**
     * @Route("/signup", name="app_sign_up")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
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
            $user->setRegDate(\DateTime());
            
            return $this->redirectToRoute('app_index');
        }
        
        return $this->render('sign_up/index.html.twig', [
            'signUpForm' => $form->createView(),
        ]);
    }
}
