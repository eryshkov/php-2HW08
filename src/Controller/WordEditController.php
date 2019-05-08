<?php

namespace App\Controller;

use App\Repository\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordEditController
 * @IsGranted("ROLE_USER")
 */
class WordEditController extends BaseController
{
    /**
     * @Route("/word/{id}/edit", name="app_word_edit")
     */
    public function index(int $id, WordRepository $wordRepository): Response
    {
        $word = $wordRepository->findOneBy([
            'id'   => $id,
            'user' => $this->getUser(),
        ]);
    
        if (!isset($word)) {
            $this->addFlash('error', 'Вы не можете изменять это слово');
            return new RedirectResponse($this->generateUrl('app_lists'));
        }
        
        return $this->render('word_edit/index.html.twig', [
            'controller_name' => 'WordEditController',
        ]);
    }
}
