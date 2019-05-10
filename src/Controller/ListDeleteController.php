<?php

namespace App\Controller;

use App\Repository\WordListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListDeleteController extends BaseController
{
    /**
     * @Route("/list/{id}/delete", name="app_list_delete")
     * @param int $id
     * @param WordListRepository $wordListRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(int $id, WordListRepository $wordListRepository, EntityManagerInterface $entityManager): Response
    {
        $list = $wordListRepository->findOneBy([
            'id'   => $id,
            'user' => $this->getUser(),
        ]);
        
        if (!isset($list)) {
            $this->addFlash('error', 'Невозможно удалить этот список');
            return new RedirectResponse($this->generateUrl('app_lists'));
        }
        
        $entityManager->remove($list);
        $entityManager->flush();
        
        $this->addFlash('success', 'Список ' . $list->getName() . ' успешно удален');
        
        return new RedirectResponse($this->generateUrl('app_lists'));
    }
}
