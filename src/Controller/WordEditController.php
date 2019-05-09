<?php

namespace App\Controller;

use App\Form\WordEditFormModel;
use App\Form\WordEditFormType;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(int $id, WordRepository $wordRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $word = $wordRepository->findOneBy([
            'id'   => $id,
            'user' => $this->getUser(),
        ]);
    
        if (!isset($word)) {
            $this->addFlash('error', 'Вы не можете изменять это слово');
            return new RedirectResponse($this->generateUrl('app_lists'));
        }
    
        $wordModel = new WordEditFormModel();
        $wordModel->english = $word->getEnglish();
        $wordModel->russian = $word->getRussian();
        $wordModel->list = $word->getList();
        
        $form = $this->createForm(WordEditFormType::class, $wordModel);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var WordEditFormModel $wordModelSubmitted */
            $wordModelSubmitted = $form->getData();
            $word->setEnglish($wordModelSubmitted->english);
            $word->setRussian($wordModelSubmitted->russian);
            $word->setList($wordModelSubmitted->list);
    
            $entityManager->persist($word);
            $entityManager->flush();
    
            $this->addFlash('success', 'Слово успешно изменено');
            return new RedirectResponse($this->generateUrl('app_words_list', [
                'id' => $word->getList()->getId(),
                
            ]));
        }
        
        return $this->render('word_edit/index.html.twig', [
            'editForm' => $form->createView(),
        ]);
    }
}
