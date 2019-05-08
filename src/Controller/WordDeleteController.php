<?php

namespace App\Controller;

use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function index(int $id, WordRepository $wordRepository, EntityManagerInterface $entityManager)
    {
        $word = $wordRepository->findOneBy([
            'id' => $id,
            'user' => $this->getUser(),
        ]);
    
        if (!isset($word)) {
            $this->addFlash('error', 'Вы не можете удалить это слово');
            return new RedirectResponse($this->generateUrl('app_lists'));
        }
    
        $list = $word->getList();
        $entityManager->remove($word);
        $entityManager->flush();
    
        $this->addFlash('success', 'Слово успешно удалено');
        return new RedirectResponse($this->generateUrl('app_words_list', [
            'id' => $list->getId(),
        ]));
    }
}
