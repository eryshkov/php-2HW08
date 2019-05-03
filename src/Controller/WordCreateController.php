<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordCreateController
 * @IsGranted("ROLE_USER")
 */
class WordCreateController extends BaseController
{
    /**
     * @Route("/word/create", name="word_create")
     */
    public function index()
    {
        $currentUser = $this->getUser();
        
        
        return $this->render('word_create/index.html.twig', [
            'user' => $currentUser,
        ]);
    }
}
