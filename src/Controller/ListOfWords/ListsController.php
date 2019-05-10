<?php

namespace App\Controller\ListOfWords;

use App\Controller\BaseController;
use App\Repository\WordListRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListsController
 * @IsGranted("ROLE_USER")
 */
class ListsController extends BaseController
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
     * @Route("/lists", name="app_lists")
     */
    public function index(): Response
    {
        $wordList = $this->wordListRepository->findBy([
            'user' => $this->getUser(),
        ], [
            'id' => 'DESC',
        ]);
        
        return $this->render('list/index.html.twig', [
            'wordLists' => $wordList,
        ]);
    }
}
