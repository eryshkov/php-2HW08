<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WordEditController extends BaseController
{
    /**
     * @Route("/word/{id}/edit", name="app_word_edit")
     */
    public function index(int $id): Response
    {
        return $this->render('word_edit/index.html.twig', [
            'controller_name' => 'WordEditController',
        ]);
    }
}
