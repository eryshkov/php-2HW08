<?php

namespace App\Controller\Word;

use App\Controller\BaseController;
use App\Repository\WordListRepository;
use App\Repository\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordsListController
 * @IsGranted("ROLE_USER")
 */
class WordsListController extends BaseController
{
    /**
     * @Route("/words/list/{id}", name="app_words_list")
     * @param int $id
     * @param WordRepository $wordRepository
     * @param WordListRepository $wordListRepository
     * @return RedirectResponse|Response
     */
    public function index(int $id, WordRepository $wordRepository, WordListRepository $wordListRepository): Response
    {
        $list = $wordListRepository->findOneBy([
            'id'   => $id,
            'user' => $this->getUser(),
        ]);
        
        if (!isset($list)) {
            return $this->redirectToRoute('app_lists');
        }
        
        $words = $wordRepository->getAllFromListByIdDESC($list);
        
        return $this->render('words_list/index.html.twig', [
            'words' => $words,
            'list'  => $list,
        ]);
    }
}
