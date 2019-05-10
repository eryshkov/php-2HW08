<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserDeleteConfirmController
 * @IsGranted("ROLE_ADMIN")
 */
class UserDeleteConfirmController extends BaseController
{
    /**
     * @Route("/user/{id}delete/confirm", name="app_user_delete_confirm")
     */
    public function index(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->findOneBy([
            'id' => $id,
        ]);
    
        if (!isset($user)) {
            $this->addFlash('error', 'Пользователь не может быть удален');
            return $this->redirectToRoute('app_admin');
        }
        
        return $this->render('user_delete_confirm/index.html.twig', [
            'userForDeletion' => $user,
        ]);
    }
}
