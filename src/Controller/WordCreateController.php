<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Word;
use App\Form\WordFormModel;
use App\Form\WordFormType;
use App\Repository\WordListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordCreateController
 * @IsGranted("ROLE_USER")
 */
class WordCreateController extends BaseController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var WordListRepository
     */
    private $wordListRepository;
    
    public function __construct(EntityManagerInterface $entityManager, WordListRepository $wordListRepository)
    {
        $this->entityManager = $entityManager;
        $this->wordListRepository = $wordListRepository;
    }
    
    /**
     * @Route("/word/create/{listId}", name="app_word_create")
     */
    public function index(int $listId, Request $request)
    {
        $currentUser = $this->getUser();
    
        $form = $this->createForm(WordFormType::class);
        $form->handleRequest($request);
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
    
            $this->entityManager->persist($word);
            $this->entityManager->flush();
        }
        
        return $this->render('word_create/index.html.twig', [
            'user' => $currentUser,
            'wordCreationForm' => $form->createView(),
            'listIsNotExists' => !isset($list),
        ]);
    }
}
