<?php

namespace App\Controller\ListOfWords;

use App\Controller\BaseController;
use App\Repository\WordListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListDeleteController
 * @IsGranted("ROLE_USER")
 */
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
            return $this->redirectToRoute('app_lists');
        }
        
        $entityManager->remove($list);
        $entityManager->flush();
        
        $this->addFlash('success', 'Список ' . $list->getName() . ' успешно удален');
        
        return $this->redirectToRoute('app_lists');
    }
}
