<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordListCreateController
 * @IsGranted("ROLE_USER")
 */
class WordListCreateController extends BaseController
{
    /**
     * @Route("/word/list/create", name="app_word_list_create")
     */
    public function index()
    {
        return $this->render('word_list_create/index.html.twig', [
            'controller_name' => 'WordListCreateController',
        ]);
    }
}
