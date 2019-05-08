<?php

namespace App\Controller;

use App\Repository\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordDeleteController
 * @IsGranted("ROLE_USER")
 */
class WordDeleteController extends BaseController
{
    /**
     * @Route("/word/{id}/delete", name="app_word_delete")
     */
    public function index(int $id, WordRepository $wordRepository)
    {
        $word = $wordRepository->findOneBy([
            'id' => $id,
            'user' => $this->getUser(),
        ]);
    
        if (!isset($word)) {
            $this->addFlash('error', 'Вы не можете удалить это слово');
            
        }
        
        return $this->render('word_delete/index.html.twig', [
            'controller_name' => 'WordDeleteController',
        ]);
    }
}
