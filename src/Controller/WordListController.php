<?php

namespace App\Controller;

use App\Repository\WordListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordListController
 * @IsGranted("ROLE_USER")
 */
class WordListController extends AbstractController
{
    /**
     * @var WordListRepository
     */
    private $wordListRepository;
    
    public function __construct(WordListRepository $wordListRepository)
    {
        $this->wordListRepository = $wordListRepository;
    }
    
    /**
     * @Route("/word/list", name="app_word_list")
     */
    public function index(): Response
    {
        $currentUser = $this->getUser();
    
        $wordList = $this->wordListRepository->findBy([
            'user' => $currentUser,
        ]);
        
        return $this->render('word_list/index.html.twig', [
            'wordList' => $wordList,
            'user' => $currentUser,
        ]);
    }
}
