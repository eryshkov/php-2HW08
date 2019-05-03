<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ListDetailsController extends BaseController
{
    /**
     * @Route("/list/{id}/details", name="app_list_details")
     */
    public function index(int $id)
    {
        $currentUser = $this->getUser();
        
        return $this->render('list_details/index.html.twig', [
            'user' => $currentUser,
        ]);
    }
}
