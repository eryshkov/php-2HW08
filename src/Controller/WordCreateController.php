<?php

namespace App\Controller;

use App\Repository\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Word;
use App\Form\DTO\WordFormModel;
use App\Form\WordFormType;
use App\Repository\WordListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
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
    /**
     * @var WordRepository
     */
    private $wordRepository;
    
    public function __construct(EntityManagerInterface $entityManager, WordListRepository $wordListRepository, WordRepository $wordRepository)
    {
        $this->entityManager = $entityManager;
        $this->wordListRepository = $wordListRepository;
        $this->wordRepository = $wordRepository;
    }
    
    /**
     * @Route("/word/create/{listId}", name="app_word_create")
     * @param int $listId
     * @param Request $request
     * @return Response
     */
    public function index(int $listId, Request $request): Response
    {
        $form = $this->createForm(WordFormType::class);
        $form->handleRequest($request);
        $list = $this->wordListRepository->findOneBy([
            'user' => $this->getUser(),
            'id'   => $listId,
        ]);
        
        if (isset($list) && $form->isSubmitted() && $form->isValid()) {
            /** @var WordFormModel $wordModel */
            $wordModel = $form->getData();
            $word = new Word();
            $word->setUser($this->getUser());
            $word->setEnglish($wordModel->english);
            $word->setRussian($wordModel->russian);
            $word->setList($list);
            
            if (!$this->wordRepository->isExistAtList($word)) {
                $this->entityManager->persist($word);
                $this->entityManager->flush();
                $this->addFlash('success', $word->getEnglish() . ' успешно создано');
            } else {
                $this->addFlash('error', $word->getEnglish() . ' уже есть в этом списке');
            }
            
            $form = $this->createForm(WordFormType::class);
        }
        
        return $this->render('word_create/index.html.twig', [
            'wordCreationForm' => $form->createView(),
            'listIsNotExists'  => !isset($list),
            'listId'           => $listId,
        ]);
    }
}
