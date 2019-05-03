<?php

namespace App\Controller;

use App\Entity\Word;
use App\Form\WordFormModel;
use App\Form\WordFormType;
use App\Repository\WordListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordCreateController
 * @IsGranted("ROLE_USER")
 */
class WordCreateController extends BaseController
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var WordListRepository
     */
    private $wordListRepository;
    
    public function __construct(Request $request, EntityManagerInterface $entityManager, WordListRepository $wordListRepository)
    {
        $this->request = $request;
        $this->entityManager = $entityManager;
        $this->wordListRepository = $wordListRepository;
    }
    
    /**
     * @Route("/word/create/{listId}", name="word_create")
     */
    public function index(int $listId)
    {
        $currentUser = $this->getUser();
    
        $form = $this->createForm(WordFormType::class);
        $form->handleRequest($this->request);
        $list = $this->wordListRepository->findOneBy([
            'user' => $currentUser,
            'id'   => $listId,
        ]);
    
        if (isset($list) && $form->isSubmitted() && $form->isValid()) {
            /** @var WordFormModel $wordModel */
            $wordModel = $form->getData();
            $word = new Word();
            $word->setUser($currentUser);
            $word->setEnglish($wordModel->english);
            $word->setRussian($wordModel->russian);
            $word->setList($list);
        }
        
        return $this->render('word_create/index.html.twig', [
            'user' => $currentUser,
            'wordCreationForm' => $form->createView(),
            'isListExists' => isset($list),
        ]);
    }
}
