<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminPageController
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPageController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        return $this->render('admin_page/index.html.twig', [
            'controller_name' => 'AdminPageController',
        ]);
    }
}
