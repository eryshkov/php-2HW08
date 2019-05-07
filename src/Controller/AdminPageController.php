<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminPageController
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPageController extends BaseController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        
        return $this->render('admin_page/index.html.twig', [
            'users' => $users,
        ]);
    }
}
