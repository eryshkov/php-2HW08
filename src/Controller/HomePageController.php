<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends BaseController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index()
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'user' => $this->getUser(),
        ]);
    }
}
