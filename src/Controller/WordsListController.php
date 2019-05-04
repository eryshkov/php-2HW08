<?php

namespace App\Controller;

use App\Repository\WordListRepository;
use App\Repository\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordsListController
 * @IsGranted("ROLE_USER")
 */
class WordsListController extends AbstractController
{
    /**
     * @Route("/words/list/{id}", name="app_words_list")
     */
    public function index(int $id, WordRepository $wordRepository, WordListRepository $wordListRepository)
    {
        $list = $wordListRepository->findOneBy([
            'id' => $id,
            'user' => $this->getUser(),
        ]);
    
        if (!isset($list)) {
            return $this->redirectToRoute('app_lists');
        }
        
        $words = $wordRepository->getAllFromList($list);
        
        return $this->render('words_list/index.html.twig', [
            'words' => $words,
            'list' => $list,
        ]);
    }
}
